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

use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\DeviceOS;
use pocketmine\network\mcpe\protocol\types\entity\EntityLink;
use pocketmine\network\mcpe\protocol\types\entity\MetadataProperty;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStack;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;
use pocketmine\network\mcpe\protocol\types\entity\PropertySyncData;
use Ramsey\Uuid\UuidInterface;
use function count;

class AddPlayerPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_PLAYER_PACKET;

	public UuidInterface $uuid;
	public string $username;
	public int $actorRuntimeId;
	public string $platformChatId = "";
	public Vector3 $position;
	public ?Vector3 $motion = null;
	public float $pitch = 0.0;
	public float $yaw = 0.0;
	public float $headYaw = 0.0;
	public ItemStackWrapper|Item $item;
	public int $gameMode;
	/**
	 * @var MetadataProperty[]
	 * @phpstan-var array<int, MetadataProperty>
	 */
	public array $metadata = [];
    public PropertySyncData $syncedProperties;

    public UpdateAbilitiesPacket $abilitiesPacket;

	/** @var EntityLink[] */
	public array $links = [];
	public string $deviceId = ""; //TODO: fill player's device ID (???)
	public int $buildPlatform = DeviceOS::UNKNOWN;

	/**
	 * @generate-create-func
	 * @param MetadataProperty[] $metadata
	 * @param EntityLink[]       $links
	 * @phpstan-param array<int, MetadataProperty> $metadata
	 */
	public static function create(
		UuidInterface $uuid,
		string $username,
		int $actorRuntimeId,
		string $platformChatId,
		Vector3 $position,
		?Vector3 $motion,
		float $pitch,
		float $yaw,
		float $headYaw,
		ItemStackWrapper|Item $item,
		int $gameMode,
		array $metadata,
        PropertySyncData $syncedProperties,
		UpdateAbilitiesPacket $abilitiesPacket,
		array $links,
		string $deviceId,
		int $buildPlatform,
	) : self{
		$result = new self;
		$result->uuid = $uuid;
		$result->username = $username;
		$result->actorRuntimeId = $actorRuntimeId;
		$result->platformChatId = $platformChatId;
		$result->position = $position;
		$result->motion = $motion;
		$result->pitch = $pitch;
		$result->yaw = $yaw;
		$result->headYaw = $headYaw;
		$result->item = $item;
		$result->gameMode = $gameMode;
		$result->metadata = $metadata;
        $result->syncedProperties = $syncedProperties;
		$result->abilitiesPacket = $abilitiesPacket;
		$result->links = $links;
		$result->deviceId = $deviceId;
		$result->buildPlatform = $buildPlatform;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->uuid = $in->getUUID();
		$this->username = $in->getString();
		if($in->getProtocolId() <= ProtocolInfo::PROTOCOL_1_19_0){
			$in->getActorUniqueId();
		}
		$this->actorRuntimeId = $in->getActorRuntimeId();
		$this->platformChatId = $in->getString();
		$this->position = $in->getVector3();
		$this->motion = $in->getVector3();
		$this->pitch = $in->getLFloat();
		$this->yaw = $in->getLFloat();
		$this->headYaw = $in->getLFloat();
		if ($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) $this->item = ItemStackWrapper::read($in);
		else $this->item = $in->getItem();

		if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_18_30){
			$this->gameMode = $in->getVarInt();
		}
		$this->metadata = $in->getEntityMetadata();
        if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_19_40){
            $this->syncedProperties = PropertySyncData::read($in);
        }

		if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_19_10){
			$this->abilitiesPacket = new UpdateAbilitiesPacket();
			$this->abilitiesPacket->decodePayload($in);
		}else{
			$packet = new AdventureSettingsPacket();
			$packet->decodePayload($in);

			$this->abilitiesPacket = UpdateAbilitiesPacket::create(
				$packet->commandPermission,
				$packet->playerPermission,
				$packet->targetActorUniqueId,
				[]
			);
		}

		$linkCount = $in->getUnsignedVarInt();
		for($i = 0; $i < $linkCount; ++$i){
			$this->links[$i] = $in->getEntityLink();
		}

		$this->deviceId = $in->getString();
		$this->buildPlatform = $in->getLInt();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUUID($this->uuid);
		$out->putString($this->username);
		if($out->getProtocolId() <= ProtocolInfo::PROTOCOL_1_19_0){
			$out->putActorUniqueId($this->abilitiesPacket->getTargetActorUniqueId());
		}
		$out->putActorRuntimeId($this->actorRuntimeId);
		$out->putString($this->platformChatId);
		$out->putVector3($this->position);
		$out->putVector3Nullable($this->motion);
		$out->putLFloat($this->pitch);
		$out->putLFloat($this->yaw);
		$out->putLFloat($this->headYaw);
		if ($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) {
			$i = $this->item;
			if ($i instanceof Item) {
				$this->item = ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet($out->getProtocolId(), $i));
			}

			$this->item->write($out);
		}
		else {
			$i = $this->item;
			if ($i instanceof ItemStackWrapper) {
				$this->item = TypeConverter::getInstance()->netItemStackToCore($out->getProtocolId(), $i->getItemStack());
			}
			$out->putItem($this->item);
		}
		if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_18_30){
			$out->putVarInt($this->gameMode);
		}
		$out->putEntityMetadata($this->metadata);
        if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_19_40){
            $this->syncedProperties->write($out);
        }

		if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_19_10){
			$this->abilitiesPacket->encodePayload($out);
		}else{
			$packet = AdventureSettingsPacket::create(
				0,
				$this->abilitiesPacket->getCommandPermission(),
				0,
				$this->abilitiesPacket->getPlayerPermission(),
				0,
				$this->abilitiesPacket->getTargetActorUniqueId()
			);
			$packet->encodePayload($out);
		}

		$out->putUnsignedVarInt(count($this->links));
		foreach($this->links as $link){
			$out->putEntityLink($link);
		}

		$out->putString($this->deviceId);
		$out->putLInt($this->buildPlatform);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleAddPlayer($this);
	}
}
