<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Logic\StockManagement;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddToStockRequest;

class StockController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(AddToStockRequest $request)
    {
        try {
            $stock = StockManagement::make($request)->addToStock();
            return sendResponse(true, "Added to Stock", $stock, 201);
        } catch(Throwable $e) {
            return Throwable($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $stock = StockManagement::make()->showStock($id);
            return sendResponse(true, "Stock details", $stock);
        } catch(Throwable $e) {
            return Throwable($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            StockManagement::make()->removeFromStock($id);
            return sendResponse(true, "Removed from stock");
        } catch(Throwable $e) {
            return Throwable($e);
        }
    }
}
