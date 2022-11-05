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

namespace pocketmine\network\mcpe\protocol\types\inventory\stackresponse;

use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class ItemStackResponseSlotInfo{

	private int $slot;
	private int $hotbarSlot;
	private int $count;
	private int $itemStackId;
	private string $customName;
	private int $durabilityCorrection;

	public function __construct(int $slot, int $hotbarSlot, int $count, int $itemStackId, string $customName, int $durabilityCorrection){
		$this->slot = $slot;
		$this->hotbarSlot = $hotbarSlot;
		$this->count = $count;
		$this->itemStackId = $itemStackId;
		$this->customName = $customName;
		$this->durabilityCorrection = $durabilityCorrection;
	}

	public function getSlot() : int{ return $this->slot; }

	public function getHotbarSlot() : int{ return $this->hotbarSlot; }

	public function getCount() : int{ return $this->count; }

	public function getItemStackId() : int{ return $this->itemStackId; }

	public function getCustomName() : string{ return $this->customName; }

	public function getDurabilityCorrection() : int{ return $this->durabilityCorrection; }

	public static function read(PacketSerializer $in) : self{
		$slot = $in->getByte();
		$hotbarSlot = $in->getByte();
		$count = $in->getByte();
		$itemStackId = $in->readGenericTypeNetworkId();
		if ($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_200)$customName = $in->getString();
		else $customName = '';
		if ($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_210) $durabilityCorrection = $in->getVarInt();
		else $durabilityCorrection = 0;
		return new self($slot, $hotbarSlot, $count, $itemStackId, $customName, $durabilityCorrection);
	}

	public function write(PacketSerializer $out) : void{
		$out->putByte($this->slot);
		$out->putByte($this->hotbarSlot);
		$out->putByte($this->count);
		$out->writeGenericTypeNetworkId($this->itemStackId);
		if ($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) $out->putString($this->customName);
		if ($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_210) $out->putVarInt($this->durabilityCorrection);
	}
}
