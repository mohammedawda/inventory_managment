<?php

namespace App\Repositories;

use App\Models\Warehouse;

class WareHouseRepository
{
    public function find(int $id)
    {
        return Warehouse::find($id);
    }
}