<?php

namespace App\Logic;

use App\Interfaces\TransferInterface;
use App\Http\Resources\StockTransferResource;
use App\Repositories\TransferRepository;
use Exception;

class StockTransfer
{
    private $payload;
    private $transferRepository;
    
    public function __construct($request)
    {
        $this->payload = $request;
        $this->transferRepository = new TransferRepository();
    }

    public static function make($request = null)
    {
        return new self($request);
    }

    public function storeTransfer()
    {
        $transfer = $this->transferRepository->store($this->payload);
        return new StockTransferResource($transfer);
    }

    public function listTransfers()
    {
        $result         = $this->transferRepository->index($this->payload);
        $result['list'] = StockTransferResource::collection($result['list']);
        return $result;
    }

    public function showTransfer($id)
    {
        $transfer = $this->transferRepository->findTransfer($id);
        if(!$transfer)
            throw new Exception("Transfer not found", 404);

        $transfer->load([
            'fromWarehouse', 'toWarehouse', 'inventoryItem', 'user'
        ]);

        return new StockTransferResource($transfer);
    }
}