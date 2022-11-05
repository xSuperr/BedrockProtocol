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

namespace pocketmine\network\mcpe\protocol\types\inventory;

use pocketmine\item\Item;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class CreativeContentEntry{

	private int $entryId;
	private ItemStack|Item $item;

	public function __construct(int $entryId, ItemStack|Item $item){
		$this->entryId = $entryId;
		$this->item = $item;
	}

	public function getEntryId() : int{ return $this->entryId; }

	public function getItem() : ItemStack|Item{ return $this->item; }

	public static function read(PacketSerializer $in) : self{
		$entryId = $in->readGenericTypeNetworkId();
		if ($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) $item = $in->getItemStackWithoutStackId();
		else $item = $in->getItem();
		return new self($entryId, $item);
	}

	public function write(PacketSerializer $out) : void{
		$out->writeGenericTypeNetworkId($this->entryId);
		if ($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) {
			$i = $this->item;
			if ($i instanceof Item) {
				$this->item = ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet($out->getProtocolId(), $i));
			}
			$out->putItemStackWithoutStackId($this->item);
		}
		else {
			$i = $this->item;
			if ($i instanceof ItemStack) {
				$this->item = TypeConverter::getInstance()->netItemStackToCore($out->getProtocolId(), $i);
			}
			$out->putItem($this->item);
		}
	}
}
