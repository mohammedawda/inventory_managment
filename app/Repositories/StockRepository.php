<?php

namespace App\Repositories;

use App\Models\Stock;
use App\Traits\HasFilter;
use Illuminate\Support\Facades\Cache;
class StockRepository
{
    use HasFilter;

    public function index($request)
    {
        return getTakenPreparedCollection(Stock::filter()
            ->with(['warehouse', 'item'])
            ->whereHas('warehouse', fn($q) => $q->filter())
            ->orWhereHas('item', fn($q) => $q->filter()),
            $request->all()
        );
        // $key = "warehouses_inventory";
        // $stocks = Cache::remember($key, now()->addMinutes(10), function () use ($request) {
        //     return Stock::with(['warehouse', 'item'])->get();
        // });
        // $filter = $request->all();
        // $stocks = $this->applyCustomFilterOnCollection($stocks, $filter)
        //             ->applyCustomSearchOnCollection($stocks, $filter)
        //             ->applyCustomRangeFilterOnCollection($stocks, $filter);
        // dd($stocks);
        // return $stocks;
    }

    public function store(array $data)
    {
        return Stock::create($data);
    }

    public function find(int $id)
    {
        return Stock::find($id);
    }

    public function delete(int $id) 
    {
        return Stock::where('id', $id)->delete();    
    }

    public function findLockForUpdateStock($warehouseId, $itemId) 
    {
        return Stock::where('warehouse_id', $warehouseId)
            ->where('inventory_item_id', $itemId)
            ->lockForUpdate()
            ->first();
    }

    public function stockQuantity($warehouseId, $itemId, $quantity) 
    {
        return Stock::create([
            'warehouse_id'       => $warehouseId,
            'inventory_item_id'  => $itemId,
            'quantity'           => $quantity,
        ]);
    }
}