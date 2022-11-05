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
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;
use Ramsey\Uuid\UuidInterface;
use function count;

class CraftingEventPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::CRAFTING_EVENT_PACKET;

	public int $windowId;
	public int $windowType;
	public UuidInterface $recipeUUID;
	/** @var ItemStackWrapper|Item[] */
	public array $input = [];
	/** @var ItemStackWrapper|Item[] */
	public array $output = [];

	/**
	 * @generate-create-func
	 * @param ItemStackWrapper|Item[] $input
	 * @param ItemStackWrapper|Item[] $output
	 */
	public static function create(int $windowId, int $windowType, UuidInterface $recipeUUID, array $input, array $output) : self{
		$result = new self;
		$result->windowId = $windowId;
		$result->windowType = $windowType;
		$result->recipeUUID = $recipeUUID;
		$result->input = $input;
		$result->output = $output;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->windowId = $in->getByte();
		$this->windowType = $in->getVarInt();
		$this->recipeUUID = $in->getUUID();

		$size = $in->getUnsignedVarInt();
		for($i = 0; $i < $size and $i < 128; ++$i){
			if ($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) $this->input[] = ItemStackWrapper::read($in);
			else $this->input[] = $in->getItem();
		}

		$size = $in->getUnsignedVarInt();
		for($i = 0; $i < $size and $i < 128; ++$i){
			if ($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) $this->output[] = ItemStackWrapper::read($in);
			else $this->output[] = $in->getItem();
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->windowId);
		$out->putVarInt($this->windowType);
		$out->putUUID($this->recipeUUID);

		$out->putUnsignedVarInt(count($this->input));
		foreach($this->input as $item){
			if ($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) {
				if ($item instanceof Item) {
					$item = ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet($out->getProtocolId(), $item));
				}
				$item->write($out);
			}
			else {
				if ($item instanceof ItemStackWrapper) {
					$item = TypeConverter::getInstance()->netItemStackToCore($out->getProtocolId(), $item->getItemStack());
				}
				$out->putItem($item);
			}
		}

		$out->putUnsignedVarInt(count($this->output));
		foreach($this->output as $item){
			if ($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) {
				if ($item instanceof Item) {
					$item = ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet($out->getProtocolId(), $item));
				}
				$item->write($out);
			}
			else {
				if ($item instanceof ItemStackWrapper) {
					$item = TypeConverter::getInstance()->netItemStackToCore($out->getProtocolId(), $item->getItemStack());
				}
				$out->putItem($item);
			}
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleCraftingEvent($this);
	}
}
