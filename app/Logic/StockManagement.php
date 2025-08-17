<?php

namespace App\Logic;

use Exception;
use App\Http\Resources\StockResource;
use App\Repositories\StockRepository;

class StockManagement
{
    private $payload;
    private $stockRepository;
    
    public function __construct($request)
    {
        $this->payload         = $request;
        $this->stockRepository = new StockRepository();
    }

    public static function make($request = null)
    {
        return new self($request);
    }

    public function addToStock()
    {
        $stock = $this->stockRepository->store($this->payload);
        return new StockResource($stock);
    }

    public function listStock()
    {
        $result         = $this->stockRepository->index($this->payload);
        $result['list'] = StockResource::collection($result['list']);
        return $result;
    }

    public function showStock($id)
    {
        $stock = $this->stockRepository->find($id);
        if(!$stock)
            throw new Exception("stock not found", 404);

        $stock->load([
            'warehouse', 'inventoryItem'
        ]);

        return new StockResource($stock);
    }

    public function removeFromStock($id)
    {
        $stock = $this->stockRepository->delete($id);
        if(!$stock)
            throw new Exception("Stock not found or may be deleted", 404);
    }
}