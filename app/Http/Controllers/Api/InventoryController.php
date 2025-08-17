<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Logic\InventoryManager;
use Illuminate\Http\Request;
use Throwable;

class InventoryController extends Controller
{
    /**
     * GET /api/inventory
     * Paginated list of inventory per warehouse with filters
     */
    public function index(Request $request)
    {
        try {
            $result = InventoryManager::make($request)->getListInventory();
            return sendResponse(true, "List inventory per warehouse", $result);
        } catch(Throwable $e) {
            return Throwable($e);
        }
    }

    /**
     * GET /api/warehouses/{id}/inventory
     * Get inventory for a specific warehouse
     */
    public function warehouseInventory(Request $request, int $warehouseId)
    {
        try {
            $request->merge(['warehouse_id' => $warehouseId]);
            return $this->index($request);
        } catch(Throwable $e) {
            return Throwable($e);
        }
    }
}