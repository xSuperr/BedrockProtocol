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
use pocketmine\network\mcpe\protocol\types\entity\MetadataProperty;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;

class AddItemActorPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_ITEM_ACTOR_PACKET;

	public int $actorUniqueId;
	public int $actorRuntimeId;
	public ItemStackWrapper|Item $item;
	public Vector3 $position;
	public ?Vector3 $motion = null;
	/**
	 * @var MetadataProperty[]
	 * @phpstan-var array<int, MetadataProperty>
	 */
	public array $metadata = [];
	public bool $isFromFishing = false;

	/**
	 * @generate-create-func
	 * @param MetadataProperty[] $metadata
	 * @phpstan-param array<int, MetadataProperty> $metadata
	 */
	public static function create(
		int $actorUniqueId,
		int $actorRuntimeId,
		ItemStackWrapper|Item $item,
		Vector3 $position,
		?Vector3 $motion,
		array $metadata,
		bool $isFromFishing,
	) : self{
		$result = new self;
		$result->actorUniqueId = $actorUniqueId;
		$result->actorRuntimeId = $actorRuntimeId;
		$result->item = $item;
		$result->position = $position;
		$result->motion = $motion;
		$result->metadata = $metadata;
		$result->isFromFishing = $isFromFishing;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->actorUniqueId = $in->getActorUniqueId();
		$this->actorRuntimeId = $in->getActorRuntimeId();
		if ($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_210) $this->item = ItemStackWrapper::read($in);
		else $this->item = $in->getItem();
		$this->position = $in->getVector3();
		$this->motion = $in->getVector3();
		$this->metadata = $in->getEntityMetadata();
		$this->isFromFishing = $in->getBool();
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putActorUniqueId($this->actorUniqueId);
		$out->putActorRuntimeId($this->actorRuntimeId);
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

		$out->putVector3($this->position);
		$out->putVector3Nullable($this->motion);
		$out->putEntityMetadata($this->metadata);
		$out->putBool($this->isFromFishing);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleAddItemActor($this);
	}
}
