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

class MobArmorEquipmentPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::MOB_ARMOR_EQUIPMENT_PACKET;

	public int $actorRuntimeId;

	//this intentionally doesn't use an array because we don't want any implicit dependencies on internal order
	public ItemStackWrapper|Item $head;
	public ItemStackWrapper|Item $chest;
	public ItemStackWrapper|Item $legs;
	public ItemStackWrapper|Item $feet;

	/**
	 * @generate-create-func
	 */
	public static function create(int $actorRuntimeId, ItemStackWrapper|Item $head, ItemStackWrapper|Item $chest, ItemStackWrapper|Item $legs, ItemStackWrapper|Item $feet) : self{
		$result = new self;
		$result->actorRuntimeId = $actorRuntimeId;
		$result->head = $head;
		$result->chest = $chest;
		$result->legs = $legs;
		$result->feet = $feet;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->actorRuntimeId = $in->getActorRuntimeId();
		if ($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$this->head = ItemStackWrapper::read($in);
			$this->chest = ItemStackWrapper::read($in);
			$this->legs = ItemStackWrapper::read($in);
			$this->feet = ItemStackWrapper::read($in);
		} else {
			$this->head = $in->getItem();
			$this->chest = $in->getItem();
			$this->legs = $in->getItem();
			$this->feet = $in->getItem();
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putActorRuntimeId($this->actorRuntimeId);
		if ($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			if ($this->head instanceof Item) {
				$this->head = ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet($out->getProtocolId(), $this->head));
			}
			if ($this->chest instanceof Item) {
				$this->chest = ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet($out->getProtocolId(), $this->chest));
			}
			if ($this->legs instanceof Item) {
				$this->legs = ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet($out->getProtocolId(), $this->legs));
			}
			if ($this->feet instanceof Item) {
				$this->feet = ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet($out->getProtocolId(), $this->feet));
			}
			$this->head->write($out);
			$this->chest->write($out);
			$this->legs->write($out);
			$this->feet->write($out);
		} else {
			if ($this->head instanceof ItemStackWrapper) {
				$this->head = TypeConverter::getInstance()->netItemStackToCore($out->getProtocolId(), $this->head->getItemStack());
			}
			if ($this->chest instanceof ItemStackWrapper) {
				$this->chest = TypeConverter::getInstance()->netItemStackToCore($out->getProtocolId(), $this->chest->getItemStack());
			}
			if ($this->legs instanceof ItemStackWrapper) {
				$this->legs = TypeConverter::getInstance()->netItemStackToCore($out->getProtocolId(), $this->legs->getItemStack());
			}
			if ($this->feet instanceof ItemStackWrapper) {
				$this->feet = TypeConverter::getInstance()->netItemStackToCore($out->getProtocolId(), $this->feet->getItemStack());
			}
			$out->putItem($this->head);
			$out->putItem($this->chest);
			$out->putItem($this->legs);
			$out->putItem($this->feet);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleMobArmorEquipment($this);
	}
}
