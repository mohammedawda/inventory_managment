<?php

namespace App\Repositories;

use App\Models\InventoryItem;

class InventoryRepository
{
    public function find(int $id)
    {
        return InventoryItem::find($id);
    }
}