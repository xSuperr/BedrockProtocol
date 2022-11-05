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

/**
 * This trait provides default implementations for all packet handlers, so that you don't have to manually write
 * handlers for every single packet even if you don't care about them.
 *
 * This file is automatically generated. Do not edit it manually.
 */
trait PacketHandlerDefaultImplTrait{

	public function handleLogin(LoginPacket $packet) : bool{
		return false;
	}

	public function handlePlayStatus(PlayStatusPacket $packet) : bool{
		return false;
	}

	public function handleServerToClientHandshake(ServerToClientHandshakePacket $packet) : bool{
		return false;
	}

	public function handleClientToServerHandshake(ClientToServerHandshakePacket $packet) : bool{
		return false;
	}

	public function handleDisconnect(DisconnectPacket $packet) : bool{
		return false;
	}

	public function handleResourcePacksInfo(ResourcePacksInfoPacket $packet) : bool{
		return false;
	}

	public function handleResourcePackStack(ResourcePackStackPacket $packet) : bool{
		return false;
	}

	public function handleResourcePackClientResponse(ResourcePackClientResponsePacket $packet) : bool{
		return false;
	}

	public function handleText(TextPacket $packet) : bool{
		return false;
	}

	public function handleSetTime(SetTimePacket $packet) : bool{
		return false;
	}

	public function handleStartGame(StartGamePacket $packet) : bool{
		return false;
	}

	public function handleAddPlayer(AddPlayerPacket $packet) : bool{
		return false;
	}

	public function handleAddActor(AddActorPacket $packet) : bool{
		return false;
	}

	public function handleRemoveActor(RemoveActorPacket $packet) : bool{
		return false;
	}

	public function handleAddItemActor(AddItemActorPacket $packet) : bool{
		return false;
	}

	public function handleTakeItemActor(TakeItemActorPacket $packet) : bool{
		return false;
	}

	public function handleMoveActorAbsolute(MoveActorAbsolutePacket $packet) : bool{
		return false;
	}

	public function handleMovePlayer(MovePlayerPacket $packet) : bool{
		return false;
	}

	public function handlePassengerJump(PassengerJumpPacket $packet) : bool{
		return false;
	}

	public function handleUpdateBlock(UpdateBlockPacket $packet) : bool{
		return false;
	}

	public function handleAddPainting(AddPaintingPacket $packet) : bool{
		return false;
	}

	public function handleTickSync(TickSyncPacket $packet) : bool{
		return false;
	}

	public function handleLevelSoundEventPacketV1(LevelSoundEventPacketV1 $packet) : bool{
		return false;
	}

	public function handleLevelEvent(LevelEventPacket $packet) : bool{
		return false;
	}

	public function handleBlockEvent(BlockEventPacket $packet) : bool{
		return false;
	}

	public function handleActorEvent(ActorEventPacket $packet) : bool{
		return false;
	}

	public function handleMobEffect(MobEffectPacket $packet) : bool{
		return false;
	}

	public function handleUpdateAttributes(UpdateAttributesPacket $packet) : bool{
		return false;
	}

	public function handleInventoryTransaction(InventoryTransactionPacket $packet) : bool{
		return false;
	}

	public function handleMobEquipment(MobEquipmentPacket $packet) : bool{
		return false;
	}

	public function handleMobArmorEquipment(MobArmorEquipmentPacket $packet) : bool{
		return false;
	}

	public function handleInteract(InteractPacket $packet) : bool{
		return false;
	}

	public function handleBlockPickRequest(BlockPickRequestPacket $packet) : bool{
		return false;
	}

	public function handleActorPickRequest(ActorPickRequestPacket $packet) : bool{
		return false;
	}

	public function handlePlayerAction(PlayerActionPacket $packet) : bool{
		return false;
	}

	public function handleHurtArmor(HurtArmorPacket $packet) : bool{
		return false;
	}

	public function handleSetActorData(SetActorDataPacket $packet) : bool{
		return false;
	}

	public function handleSetActorMotion(SetActorMotionPacket $packet) : bool{
		return false;
	}

	public function handleSetActorLink(SetActorLinkPacket $packet) : bool{
		return false;
	}

	public function handleSetHealth(SetHealthPacket $packet) : bool{
		return false;
	}

	public function handleSetSpawnPosition(SetSpawnPositionPacket $packet) : bool{
		return false;
	}

	public function handleAnimate(AnimatePacket $packet) : bool{
		return false;
	}

	public function handleRespawn(RespawnPacket $packet) : bool{
		return false;
	}

	public function handleContainerOpen(ContainerOpenPacket $packet) : bool{
		return false;
	}

	public function handleContainerClose(ContainerClosePacket $packet) : bool{
		return false;
	}

	public function handlePlayerHotbar(PlayerHotbarPacket $packet) : bool{
		return false;
	}

	public function handleInventoryContent(InventoryContentPacket $packet) : bool{
		return false;
	}

	public function handleInventorySlot(InventorySlotPacket $packet) : bool{
		return false;
	}

	public function handleContainerSetData(ContainerSetDataPacket $packet) : bool{
		return false;
	}

	public function handleCraftingData(CraftingDataPacket $packet) : bool{
		return false;
	}

	public function handleCraftingEvent(CraftingEventPacket $packet) : bool{
		return false;
	}

	public function handleGuiDataPickItem(GuiDataPickItemPacket $packet) : bool{
		return false;
	}

	public function handleAdventureSettings(AdventureSettingsPacket $packet) : bool{
		return false;
	}

	public function handleBlockActorData(BlockActorDataPacket $packet) : bool{
		return false;
	}

	public function handlePlayerInput(PlayerInputPacket $packet) : bool{
		return false;
	}

	public function handleLevelChunk(LevelChunkPacket $packet) : bool{
		return false;
	}

	public function handleSetCommandsEnabled(SetCommandsEnabledPacket $packet) : bool{
		return false;
	}

	public function handleSetDifficulty(SetDifficultyPacket $packet) : bool{
		return false;
	}

	public function handleChangeDimension(ChangeDimensionPacket $packet) : bool{
		return false;
	}

	public function handleSetPlayerGameType(SetPlayerGameTypePacket $packet) : bool{
		return false;
	}

	public function handlePlayerList(PlayerListPacket $packet) : bool{
		return false;
	}

	public function handleSimpleEvent(SimpleEventPacket $packet) : bool{
		return false;
	}

	public function handleEvent(EventPacket $packet) : bool{
		return false;
	}

	public function handleSpawnExperienceOrb(SpawnExperienceOrbPacket $packet) : bool{
		return false;
	}

	public function handleClientboundMapItemData(ClientboundMapItemDataPacket $packet) : bool{
		return false;
	}

	public function handleMapInfoRequest(MapInfoRequestPacket $packet) : bool{
		return false;
	}

	public function handleRequestChunkRadius(RequestChunkRadiusPacket $packet) : bool{
		return false;
	}

	public function handleChunkRadiusUpdated(ChunkRadiusUpdatedPacket $packet) : bool{
		return false;
	}

	public function handleItemFrameDropItem(ItemFrameDropItemPacket $packet) : bool{
		return false;
	}

	public function handleGameRulesChanged(GameRulesChangedPacket $packet) : bool{
		return false;
	}

	public function handleCamera(CameraPacket $packet) : bool{
		return false;
	}

	public function handleBossEvent(BossEventPacket $packet) : bool{
		return false;
	}

	public function handleShowCredits(ShowCreditsPacket $packet) : bool{
		return false;
	}

	public function handleAvailableCommands(AvailableCommandsPacket $packet) : bool{
		return false;
	}

	public function handleCommandRequest(CommandRequestPacket $packet) : bool{
		return false;
	}

	public function handleCommandBlockUpdate(CommandBlockUpdatePacket $packet) : bool{
		return false;
	}

	public function handleCommandOutput(CommandOutputPacket $packet) : bool{
		return false;
	}

	public function handleUpdateTrade(UpdateTradePacket $packet) : bool{
		return false;
	}

	public function handleUpdateEquip(UpdateEquipPacket $packet) : bool{
		return false;
	}

	public function handleResourcePackDataInfo(ResourcePackDataInfoPacket $packet) : bool{
		return false;
	}

	public function handleResourcePackChunkData(ResourcePackChunkDataPacket $packet) : bool{
		return false;
	}

	public function handleResourcePackChunkRequest(ResourcePackChunkRequestPacket $packet) : bool{
		return false;
	}

	public function handleTransfer(TransferPacket $packet) : bool{
		return false;
	}

	public function handlePlaySound(PlaySoundPacket $packet) : bool{
		return false;
	}

	public function handleStopSound(StopSoundPacket $packet) : bool{
		return false;
	}

	public function handleSetTitle(SetTitlePacket $packet) : bool{
		return false;
	}

	public function handleAddBehaviorTree(AddBehaviorTreePacket $packet) : bool{
		return false;
	}

	public function handleStructureBlockUpdate(StructureBlockUpdatePacket $packet) : bool{
		return false;
	}

	public function handleShowStoreOffer(ShowStoreOfferPacket $packet) : bool{
		return false;
	}

	public function handlePurchaseReceipt(PurchaseReceiptPacket $packet) : bool{
		return false;
	}

	public function handlePlayerSkin(PlayerSkinPacket $packet) : bool{
		return false;
	}

	public function handleSubClientLogin(SubClientLoginPacket $packet) : bool{
		return false;
	}

	public function handleAutomationClientConnect(AutomationClientConnectPacket $packet) : bool{
		return false;
	}

	public function handleSetLastHurtBy(SetLastHurtByPacket $packet) : bool{
		return false;
	}

	public function handleBookEdit(BookEditPacket $packet) : bool{
		return false;
	}

	public function handleNpcRequest(NpcRequestPacket $packet) : bool{
		return false;
	}

	public function handlePhotoTransfer(PhotoTransferPacket $packet) : bool{
		return false;
	}

	public function handleModalFormRequest(ModalFormRequestPacket $packet) : bool{
		return false;
	}

	public function handleModalFormResponse(ModalFormResponsePacket $packet) : bool{
		return false;
	}

	public function handleServerSettingsRequest(ServerSettingsRequestPacket $packet) : bool{
		return false;
	}

	public function handleServerSettingsResponse(ServerSettingsResponsePacket $packet) : bool{
		return false;
	}

	public function handleShowProfile(ShowProfilePacket $packet) : bool{
		return false;
	}

	public function handleSetDefaultGameType(SetDefaultGameTypePacket $packet) : bool{
		return false;
	}

	public function handleRemoveObjective(RemoveObjectivePacket $packet) : bool{
		return false;
	}

	public function handleSetDisplayObjective(SetDisplayObjectivePacket $packet) : bool{
		return false;
	}

	public function handleSetScore(SetScorePacket $packet) : bool{
		return false;
	}

	public function handleLabTable(LabTablePacket $packet) : bool{
		return false;
	}

	public function handleUpdateBlockSynced(UpdateBlockSyncedPacket $packet) : bool{
		return false;
	}

	public function handleMoveActorDelta(MoveActorDeltaPacket $packet) : bool{
		return false;
	}

	public function handleSetScoreboardIdentity(SetScoreboardIdentityPacket $packet) : bool{
		return false;
	}

	public function handleSetLocalPlayerAsInitialized(SetLocalPlayerAsInitializedPacket $packet) : bool{
		return false;
	}

	public function handleUpdateSoftEnum(UpdateSoftEnumPacket $packet) : bool{
		return false;
	}

	public function handleNetworkStackLatency(NetworkStackLatencyPacket $packet) : bool{
		return false;
	}

	public function handleScriptCustomEvent(ScriptCustomEventPacket $packet) : bool{
		return false;
	}

	public function handleSpawnParticleEffect(SpawnParticleEffectPacket $packet) : bool{
		return false;
	}

	public function handleAvailableActorIdentifiers(AvailableActorIdentifiersPacket $packet) : bool{
		return false;
	}

	public function handleLevelSoundEventPacketV2(LevelSoundEventPacketV2 $packet) : bool{
		return false;
	}

	public function handleNetworkChunkPublisherUpdate(NetworkChunkPublisherUpdatePacket $packet) : bool{
		return false;
	}

	public function handleBiomeDefinitionList(BiomeDefinitionListPacket $packet) : bool{
		return false;
	}

	public function handleLevelSoundEvent(LevelSoundEventPacket $packet) : bool{
		return false;
	}

	public function handleLevelEventGeneric(LevelEventGenericPacket $packet) : bool{
		return false;
	}

	public function handleLecternUpdate(LecternUpdatePacket $packet) : bool{
		return false;
	}

	public function handleAddEntity(AddEntityPacket $packet) : bool{
		return false;
	}

	public function handleRemoveEntity(RemoveEntityPacket $packet) : bool{
		return false;
	}

	public function handleClientCacheStatus(ClientCacheStatusPacket $packet) : bool{
		return false;
	}

	public function handleOnScreenTextureAnimation(OnScreenTextureAnimationPacket $packet) : bool{
		return false;
	}

	public function handleMapCreateLockedCopy(MapCreateLockedCopyPacket $packet) : bool{
		return false;
	}

	public function handleStructureTemplateDataRequest(StructureTemplateDataRequestPacket $packet) : bool{
		return false;
	}

	public function handleStructureTemplateDataResponse(StructureTemplateDataResponsePacket $packet) : bool{
		return false;
	}

	public function handleClientCacheBlobStatus(ClientCacheBlobStatusPacket $packet) : bool{
		return false;
	}

	public function handleClientCacheMissResponse(ClientCacheMissResponsePacket $packet) : bool{
		return false;
	}

	public function handleEducationSettings(EducationSettingsPacket $packet) : bool{
		return false;
	}

	public function handleEmote(EmotePacket $packet) : bool{
		return false;
	}

	public function handleMultiplayerSettings(MultiplayerSettingsPacket $packet) : bool{
		return false;
	}

	public function handleSettingsCommand(SettingsCommandPacket $packet) : bool{
		return false;
	}

	public function handleAnvilDamage(AnvilDamagePacket $packet) : bool{
		return false;
	}

	public function handleCompletedUsingItem(CompletedUsingItemPacket $packet) : bool{
		return false;
	}

	public function handleNetworkSettings(NetworkSettingsPacket $packet) : bool{
		return false;
	}

	public function handlePlayerAuthInput(PlayerAuthInputPacket $packet) : bool{
		return false;
	}

	public function handleCreativeContent(CreativeContentPacket $packet) : bool{
		return false;
	}

	public function handlePlayerEnchantOptions(PlayerEnchantOptionsPacket $packet) : bool{
		return false;
	}

	public function handleItemStackRequest(ItemStackRequestPacket $packet) : bool{
		return false;
	}

	public function handleItemStackResponse(ItemStackResponsePacket $packet) : bool{
		return false;
	}

	public function handlePlayerArmorDamage(PlayerArmorDamagePacket $packet) : bool{
		return false;
	}

	public function handleCodeBuilder(CodeBuilderPacket $packet) : bool{
		return false;
	}

	public function handleUpdatePlayerGameType(UpdatePlayerGameTypePacket $packet) : bool{
		return false;
	}

	public function handleEmoteList(EmoteListPacket $packet) : bool{
		return false;
	}

	public function handlePositionTrackingDBServerBroadcast(PositionTrackingDBServerBroadcastPacket $packet) : bool{
		return false;
	}

	public function handlePositionTrackingDBClientRequest(PositionTrackingDBClientRequestPacket $packet) : bool{
		return false;
	}

	public function handleDebugInfo(DebugInfoPacket $packet) : bool{
		return false;
	}

	public function handlePacketViolationWarning(PacketViolationWarningPacket $packet) : bool{
		return false;
	}

	public function handleMotionPredictionHints(MotionPredictionHintsPacket $packet) : bool{
		return false;
	}

	public function handleAnimateEntity(AnimateEntityPacket $packet) : bool{
		return false;
	}

	public function handleCameraShake(CameraShakePacket $packet) : bool{
		return false;
	}

	public function handlePlayerFog(PlayerFogPacket $packet) : bool{
		return false;
	}

	public function handleCorrectPlayerMovePrediction(CorrectPlayerMovePredictionPacket $packet) : bool{
		return false;
	}

	public function handleItemComponent(ItemComponentPacket $packet) : bool{
		return false;
	}

	public function handleFilterText(FilterTextPacket $packet) : bool{
		return false;
	}

	public function handleClientboundDebugRenderer(ClientboundDebugRendererPacket $packet) : bool{
		return false;
	}

	public function handleSyncActorProperty(SyncActorPropertyPacket $packet) : bool{
		return false;
	}

	public function handleAddVolumeEntity(AddVolumeEntityPacket $packet) : bool{
		return false;
	}

	public function handleRemoveVolumeEntity(RemoveVolumeEntityPacket $packet) : bool{
		return false;
	}

	public function handleSimulationType(SimulationTypePacket $packet) : bool{
		return false;
	}

	public function handleNpcDialogue(NpcDialoguePacket $packet) : bool{
		return false;
	}

	public function handleEduUriResource(EduUriResourcePacket $packet) : bool{
		return false;
	}

	public function handleCreatePhoto(CreatePhotoPacket $packet) : bool{
		return false;
	}

	public function handleUpdateSubChunkBlocks(UpdateSubChunkBlocksPacket $packet) : bool{
		return false;
	}

	public function handlePhotoInfoRequest(PhotoInfoRequestPacket $packet) : bool{
		return false;
	}

	public function handleSubChunk(SubChunkPacket $packet) : bool{
		return false;
	}

	public function handleSubChunkRequest(SubChunkRequestPacket $packet) : bool{
		return false;
	}

	public function handlePlayerStartItemCooldown(PlayerStartItemCooldownPacket $packet) : bool{
		return false;
	}

	public function handleScriptMessage(ScriptMessagePacket $packet) : bool{
		return false;
	}

	public function handleCodeBuilderSource(CodeBuilderSourcePacket $packet) : bool{
		return false;
	}

	public function handleTickingAreasLoadStatus(TickingAreasLoadStatusPacket $packet) : bool{
		return false;
	}

	public function handleDimensionData(DimensionDataPacket $packet) : bool{
		return false;
	}

	public function handleAgentActionEvent(AgentActionEventPacket $packet) : bool{
		return false;
	}

	public function handleChangeMobProperty(ChangeMobPropertyPacket $packet) : bool{
		return false;
	}

	public function handleLessonProgress(LessonProgressPacket $packet) : bool{
		return false;
	}

	public function handleRequestAbility(RequestAbilityPacket $packet) : bool{
		return false;
	}

	public function handleRequestPermissions(RequestPermissionsPacket $packet) : bool{
		return false;
	}

	public function handleToastRequest(ToastRequestPacket $packet) : bool{
		return false;
	}

	public function handleUpdateAbilities(UpdateAbilitiesPacket $packet) : bool{
		return false;
	}

	public function handleUpdateAdventureSettings(UpdateAdventureSettingsPacket $packet) : bool{
		return false;
	}

	public function handleDeathInfo(DeathInfoPacket $packet) : bool{
		return false;
	}

	public function handleEditorNetwork(EditorNetworkPacket $packet) : bool{
		return false;
	}

	public function handleFeatureRegistry(FeatureRegistryPacket $packet) : bool{
		return false;
	}

    public function handleServerStats(ServerStatsPacket $packet) : bool{
        return false;
    }

    public function handleRequestNetworkSettings(RequestNetworkSettingsPacket $packet) : bool{
        return false;
    }

    public function handleGameTestRequest(GameTestRequestPacket $packet) : bool{
        return false;
    }

    public function handleGameTestResults(GameTestResultsPacket $packet) : bool{
        return false;
    }
}