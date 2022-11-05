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

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\nbt\tag\CompoundTag;

final class BlockPaletteEntry210{

	private string $name;
	private CompoundTag $states;

	public function __construct(string $name, CompoundTag $states){
		$this->name = $name;
		$this->states = $states;
	}

	public function getName() : string{ return $this->name; }

	public function getStates() : CompoundTag{ return $this->states; }
}
