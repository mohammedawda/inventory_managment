<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Logic\StockTransfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransferRequest;

class StockTransferController extends Controller
{
    /**
     * POST /api/stock-transfers
     * make a transfer between warehouses
     */
    public function store(StoreTransferRequest $request)
    {
        try {
            $transfer = StockTransfer::make($request)->storeTransfer();
            return sendResponse(true, "Transfer completed", $transfer, 201);
        } catch(Throwable $e) {
            return Throwable($e);
        }
    }

    /**
     * GET /api/stock-transfers
     * List stock transfers with filters
     */
    public function index(Request $request)
    {
        try {
            $result = StockTransfer::make($request)->listTransfers();
            return sendResponse(true, "Transfer completed", $result, 201);
        } catch(Throwable $e) {
            return Throwable($e);
        }
    }

    /**
     * GET /api/stock-transfers/{id}
     * Get specific transfer details
     */
    public function show(int $id)
    {
        try {
            $transfer = StockTransfer::make()->showTransfer($id);
            return sendResponse(true, "Transfer completed", $transfer, 201);
        } catch(Throwable $e) {
            return Throwable($e);
        }
    }
}