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

namespace pocketmine\network\mcpe\protocol\types\recipe;

use pocketmine\item\Item;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\CraftingDataPacket;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStack;

final class FurnaceRecipe extends RecipeWithTypeId{

	private int $inputId;
	private ?int $inputMeta;
	private ItemStack|Item $result;
	private string $blockName;

	public function __construct(int $typeId, int $inputId, ?int $inputMeta, ItemStack|Item $result, string $blockName){
		parent::__construct($typeId);
		$this->inputId = $inputId;
		$this->inputMeta = $inputMeta;
		$this->result = $result;
		$this->blockName = $blockName;
	}

	public function getInputId() : int{
		return $this->inputId;
	}

	public function getInputMeta() : ?int{
		return $this->inputMeta;
	}

	public function getResult() : ItemStack{
		return $this->result;
	}

	public function getBlockName() : string{
		return $this->blockName;
	}

	public static function decode(int $typeId, PacketSerializer $in) : self{
		$inputId = $in->getVarInt();
		$inputData = null;
		if($typeId === CraftingDataPacket::ENTRY_FURNACE_DATA){
			$inputData = $in->getVarInt();
		}
		if ($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) $output = $in->getItemStackWithoutStackId();
		else $output = $in->getItem();

		$block = $in->getString();

		return new self($typeId, $inputId, $inputData, $output, $block);
	}

	public function encode(PacketSerializer $out) : void{
		$out->putVarInt($this->inputId);
		if($this->getTypeId() === CraftingDataPacket::ENTRY_FURNACE_DATA){
			$out->putVarInt($this->inputMeta);
		}
		if ($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) {
			$i = $this->result;
			if ($i instanceof Item) {
				$this->result = ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet($out->getProtocolId(), $i));
			}

			$out->putItemStackWithoutStackId($this->result);
		}
		else {
			if ($this->result instanceof ItemStack) {
				$this->result = TypeConverter::getInstance()->netItemStackToCore($out->getProtocolId(), $this->result);
			}
			$out->putItem($this->result);
		}
		$out->putString($this->blockName);
	}
}
