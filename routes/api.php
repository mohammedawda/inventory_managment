<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\HasValidTokenMiddleware;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\StockTransferController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

# ================================================== Authentication ================================================== #
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
# ==================================================================================================================== #


Route::group(['middleware' => ['auth:sanctum', HasValidTokenMiddleware::class]], function() {
    # ================================================== Authentication ================================================== #
    Route::post('/logout', [AuthController::class, 'logout']);
    # ================================================== Inventory ================================================== #
    Route::get('/inventory', [InventoryController::class, 'index']);
    Route::get('/warehouses/{warehouse_id}/inventory', [InventoryController::class, 'warehouseInventory']);
    # ================================================== Stock transfer ================================================== #
    Route::post('/stock-transfers', [StockTransferController::class, 'store']);
    Route::get('/stock-transfers', [StockTransferController::class, 'index']);
    Route::get('/stock-transfers/{id}', [StockTransferController::class, 'show']);
});
