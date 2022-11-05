<?php

/*
 * This file is part of BedrockProtocol.
 * Copyright (C) 2014-2022 PocketMine Team <https://github.com/pmmp/BedrockProtocol>
 *
 * BedrockProtocol is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\InventoryTransactionChangedSlotsHack;
use pocketmine\network\mcpe\protocol\types\inventory\MismatchTransactionData;
use pocketmine\network\mcpe\protocol\types\inventory\NormalTransactionData;
use pocketmine\network\mcpe\protocol\types\inventory\ReleaseItemTransactionData;
use pocketmine\network\mcpe\protocol\types\inventory\TransactionData;
use pocketmine\network\mcpe\protocol\types\inventory\NetworkInventoryAction;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemOnEntityTransactionData;
use pocketmine\network\mcpe\protocol\types\inventory\UseItemTransactionData;
use stdClass;
use pocketmine\network\mcpe\protocol\types\BlockPosition;
use function count;

/**
 * This packet effectively crams multiple packets into one.
 */
class InventoryTransactionPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::INVENTORY_TRANSACTION_PACKET;

	public const TYPE_NORMAL = 0;
	public const TYPE_MISMATCH = 1;
	public const TYPE_USE_ITEM = 2;
	public const TYPE_USE_ITEM_ON_ENTITY = 3;
	public const TYPE_RELEASE_ITEM = 4;

    public const USE_ITEM_ACTION_CLICK_BLOCK = 0;
    public const USE_ITEM_ACTION_CLICK_AIR = 1;
    public const USE_ITEM_ACTION_BREAK_BLOCK = 2;

    public const RELEASE_ITEM_ACTION_RELEASE = 0; //bow shoot
    public const RELEASE_ITEM_ACTION_CONSUME = 1; //eat food, drink potion

    public const USE_ITEM_ON_ENTITY_ACTION_INTERACT = 0;
    public const USE_ITEM_ON_ENTITY_ACTION_ATTACK = 1;

	public int $requestId;
	/** @var InventoryTransactionChangedSlotsHack[] */
	public array $requestChangedSlots;
	public TransactionData $trData;

    /** @var int */
    public $transactionType;
    /** @var bool */
    public $hasItemStackIds;

    /** @var NetworkInventoryAction[] */
    public $actions = [];

    /** @var stdClass */
    public $oldTrData;

	/**
	 * @generate-create-func
	 * @param InventoryTransactionChangedSlotsHack[] $requestChangedSlots
	 */
	public static function create(int $requestId, array $requestChangedSlots, TransactionData $trData) : self{
		$result = new self;
		$result->requestId = $requestId;
		$result->requestChangedSlots = $requestChangedSlots;
		$result->trData = $trData;
		return $result;
	}

    public static function create220(int $requestId, array $requestChangedSlots, int $transactionType, bool $hasItemStackIds, array $actions): self
    {

    }

    protected function pre220Decode(PacketSerializer $in){
        $this->requestId = $in->readGenericTypeNetworkId();
        $this->requestChangedSlots = [];
        if($this->requestId !== 0){
            for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
                $this->requestChangedSlots[] = InventoryTransactionChangedSlotsHack::read($in);
            }
        }

        $this->transactionType = $in->getUnsignedVarInt();
        $this->hasItemStackIds = $in->getBool();
        for($i = 0, $count = $in->getUnsignedVarInt(); $i < $count; ++$i){
            $this->actions[] = $action = (new NetworkInventoryAction())->read210($in, $this->hasItemStackIds);
        }

        $this->oldTrData = new stdClass();

        switch($this->transactionType){
            case self::TYPE_NORMAL:
            case self::TYPE_MISMATCH:
                //Regular ComplexInventoryTransaction doesn't read any extra data
                break;
            case self::TYPE_USE_ITEM:
                $this->oldTrData->actionType = $in->getUnsignedVarInt();
                $bPos = $in->getBlockPosition();
                $this->oldTrData->x = $bPos->getX();
                $this->oldTrData->y = $bPos->getY();
                $this->oldTrData->z = $bPos->getZ();
                $this->oldTrData->face = $in->getVarInt();
                $this->oldTrData->hotbarSlot = $in->getVarInt();
                $this->oldTrData->itemInHand = $in->getItem();
                $this->oldTrData->playerPos = $in->getVector3();
                $this->oldTrData->clickPos = $in->getVector3();
                $this->oldTrData->blockRuntimeId = $in->getUnsignedVarInt();
                break;
            case self::TYPE_USE_ITEM_ON_ENTITY:
                $this->oldTrData->entityRuntimeId = $in->getActorRuntimeId();
                $this->oldTrData->actionType = $in->getUnsignedVarInt();
                $this->oldTrData->hotbarSlot = $in->getVarInt();
                $this->oldTrData->itemInHand = $in->getItem();
                $this->oldTrData->playerPos = $in->getVector3();
                $this->oldTrData->clickPos = $in->getVector3();
                break;
            case self::TYPE_RELEASE_ITEM:
                $this->oldTrData->actionType = $in->getUnsignedVarInt();
                $this->oldTrData->hotbarSlot = $in->getVarInt();
                $this->oldTrData->itemInHand = $in->getItem();
                $this->oldTrData->headPos = $in->getVector3();
                break;
            default:
                throw new \UnexpectedValueException("Unknown transaction type $this->transactionType");
        }
    }

    protected function pre220Encode(PacketSerializer $out){
        $out->writeGenericTypeNetworkId($this->requestId);
        if($this->requestId !== 0){
            $out->putUnsignedVarInt(count($this->requestChangedSlots));
            foreach($this->requestChangedSlots as $changedSlots){
                $changedSlots->write($out);
            }
        }

        $out->putUnsignedVarInt($this->transactionType);

        $out->putBool($this->hasItemStackIds);

        $out->putUnsignedVarInt(count($this->actions));
        foreach($this->actions as $action){
            $action->write210($out, $this->hasItemStackIds);
        }

        switch($this->transactionType){
            case self::TYPE_NORMAL:
            case self::TYPE_MISMATCH:
                break;
            case self::TYPE_USE_ITEM:
                $out->putUnsignedVarInt($this->oldTrData->actionType);
                $out->putBlockPosition(new BlockPosition($this->oldTrData->x, $this->oldTrData->y, $this->oldTrData->z));
                $out->putVarInt($this->oldTrData->face);
                $out->putVarInt($this->oldTrData->hotbarSlot);
                $out->putSlot($this->oldTrData->itemInHand);
                $out->putVector3($this->oldTrData->playerPos);
                $out->putVector3($this->oldTrData->clickPos);
                $out->putUnsignedVarInt($this->oldTrData->blockRuntimeId);
                break;
            case self::TYPE_USE_ITEM_ON_ENTITY:
                $out->putActorRuntimeId($this->oldTrData->entityRuntimeId);
                $out->putUnsignedVarInt($this->oldTrData->actionType);
                $out->putVarInt($this->oldTrData->hotbarSlot);
                $out->putItem($this->oldTrData->itemInHand);
                $out->putVector3($this->oldTrData->playerPos);
                $out->putVector3($this->oldTrData->clickPos);
                break;
            case self::TYPE_RELEASE_ITEM:
                $out->putUnsignedVarInt($this->oldTrData->actionType);
                $out->putVarInt($this->oldTrData->hotbarSlot);
                $out->putItem($this->oldTrData->itemInHand);
                $out->putVector3($this->oldTrData->headPos);
                break;
            default:
                throw new \InvalidArgumentException("Unknown transaction type $this->transactionType");
        }
    }

	protected function decodePayload(PacketSerializer $in) : void{
        if ($in->getProtocolId() <= ProtocolInfo::PROTOCOL_1_16_210) {
            $this->pre220Decode($in);
            return;
        }

		$this->requestId = $in->readGenericTypeNetworkId();
		$this->requestChangedSlots = [];
		if($this->requestId !== 0){
			for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
				$this->requestChangedSlots[] = InventoryTransactionChangedSlotsHack::read($in);
			}
		}

		$transactionType = $in->getUnsignedVarInt();

		$this->trData = match($transactionType){
			NormalTransactionData::ID => new NormalTransactionData(),
			MismatchTransactionData::ID => new MismatchTransactionData(),
			UseItemTransactionData::ID => new UseItemTransactionData(),
			UseItemOnEntityTransactionData::ID => new UseItemOnEntityTransactionData(),
			ReleaseItemTransactionData::ID => new ReleaseItemTransactionData(),
			default => throw new PacketDecodeException("Unknown transaction type $transactionType"),
		};

		$this->trData->decode($in);
	}

	protected function encodePayload(PacketSerializer $out) : void{
        if ($out->getProtocolId() <= ProtocolInfo::PROTOCOL_1_16_210) {
            $this->pre220Encode($out);
            return;
        }

		$out->writeGenericTypeNetworkId($this->requestId);
		if($this->requestId !== 0){
			$out->putUnsignedVarInt(count($this->requestChangedSlots));
			foreach($this->requestChangedSlots as $changedSlots){
				$changedSlots->write($out);
			}
		}

		$out->putUnsignedVarInt($this->trData->getTypeId());

		$this->trData->encode($out);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleInventoryTransaction($this);
	}
}
