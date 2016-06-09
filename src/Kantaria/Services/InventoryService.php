<?php

namespace Kantaria\Services;

class InventoryService
{
    public function purgeCharacterInventory($characterId)
    {
        $q = new InventoryQuery();
        $q->filterByCharacterId($characterId);
        $q->delete();
    }
}