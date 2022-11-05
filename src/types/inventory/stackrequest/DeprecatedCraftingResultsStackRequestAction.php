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

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\item\Item;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\GetTypeIdFromConstTrait;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStack;
use function count;

/**
 * Not clear what this is needed for, but it is very clearly marked as deprecated, so hopefully it'll go away before I
 * have to write a proper description for it.
 */
final class DeprecatedCraftingResultsStackRequestAction extends ItemStackRequestAction{
	use GetTypeIdFromConstTrait;

	public const ID = ItemStackRequestActionType::CRAFTING_RESULTS_DEPRECATED_ASK_TY_LAING;

	/** @var ItemStack|Item[] */
	private array $results;
	private int $iterations;

	/**
	 * @param ItemStack|Item[] $results
	 */
	public function __construct(array $results, int $iterations){
		$this->results = $results;
		$this->iterations = $iterations;
	}

	/** @return ItemStack|Item[] */
	public function getResults() : array{ return $this->results; }

	public function getIterations() : int{ return $this->iterations; }

	public static function read(PacketSerializer $in) : self{
		$results = [];
		for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
			if ($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) $results[] = $in->getItemStackWithoutStackId();
			else $results[] = $in->getItem();
		}
		$iterations = $in->getByte();
		return new self($results, $iterations);
	}

	public function write(PacketSerializer $out) : void{
		$out->putUnsignedVarInt(count($this->results));
		foreach($this->results as $result){
			if ($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220) {
				if ($result instanceof Item) {
					$result = ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet($out->getProtocolId(), $result));
				}
				$out->putItemStackWithoutStackId($result);
			}
			else {
				if ($result instanceof ItemStack) {
					$result = TypeConverter::getInstance()->netItemStackToCore($out->getProtocolId(), $result);
				}
				$out->putItem($result);
			}
		}
		$out->putByte($this->iterations);
	}
}
