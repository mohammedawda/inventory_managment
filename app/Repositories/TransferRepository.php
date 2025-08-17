<?php

namespace App\Repositories;

use Throwable;
use App\Models\StockTransfer;
use App\Events\LowStockDetected;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class TransferRepository
{
    public function store($request)
    {
        try {
            $userId = $request->user()->id;
            return DB::transaction(function () use ($request, $userId) {
                $stockRepo = new StockRepository();
                // Lock source row
                $source = $stockRepo->findLockForUpdateStock($request->from_warehouse_id, $request->inventory_item_id);
    
                if (! $source || $source->quantity < $request->quantity) {
                    throw ValidationException::withMessages([
                        'quantity' => 'Insufficient stock in source warehouse.',
                    ]);
                }

                // Lock destination row (or create)
                $destination = $stockRepo->findLockForUpdateStock($request->to_warehouse_id, $request->inventory_item_id);
                if (!$destination)
                    $destination = $stockRepo->stockQuantity($request->to_warehouse_id, $request->inventory_item_id, 0);
    
                // Perform transfer
                $source->decrement('quantity', $request->quantity);
                $destination->increment('quantity', $request->quantity);
    
                
                // Log transfer
                $transfer = $this->logTransfer($userId, $request->inventory_item_id, $request->from_warehouse_id, $request->to_warehouse_id, $request->quantity);
                $transfer->load(['fromWarehouse', 'toWarehouse', 'item']);
    
                // Invalidate caches for both warehouses
                $this->forgetWarehouseInventoryCache($request->from_warehouse_id);
                $this->forgetWarehouseInventoryCache($request->to_warehouse_id);

                if ($source->isLowStock()) {
                    $item = ( new InventoryRepository() )->find($request->inventory_item_id);
                    LowStockDetected::dispatch($source->warehouse, $item, $source->quantity);
                }
    
                return $transfer;
            });
        } catch(Throwable $e) {
            throw $e;
        }
    }

    public function index($request)
    {
        return getTakenPreparedCollection(StockTransfer::filter()->with(['fromWarehouse', 'toWarehouse', 'item', 'user']), $request->all());
    }

    public function findTransfer(int $id)
    {
        return StockTransfer::find($id);
    }

    public function logTransfer($userId, $itemId, $fromWareHouseId, $toWareHouseId, $quantity)
    {
        return StockTransfer::create([
            'inventory_item_id' => $itemId,
            'from_warehouse_id' => $fromWareHouseId,
            'to_warehouse_id'   => $toWareHouseId,
            'quantity'          => $quantity,
            'user_id'           => $userId,
        ]);
    }

    public function forgetWarehouseInventoryCache(int $warehouseId): void
    {
        Cache::forget(self::cacheKey($warehouseId));
    }

    public static function cacheKey(int $warehouseId): string
    {
        return "warehouse:{$warehouseId}:inventory";
    }
}