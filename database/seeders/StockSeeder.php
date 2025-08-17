<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses     = Warehouse::limit(10)->get();
        $inventoryItems = InventoryItem::limit(10)->get();
        $stocks         = [];
        $index = 0;
        foreach($warehouses as $warehouse) {
            $stocks[] = [
                'warehouse_id'      => $warehouse->id,
                'inventory_item_id' => $inventoryItems->first()->id,
                'quantity'          => 10,
                'min_stock_level'   => 5,
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
            unset($inventoryItems[$index]);
            $index++;
        }
        Stock::insert($stocks);
    }
}
