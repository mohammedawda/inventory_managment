<?php

namespace App\Logic;

class InventoryManager
{
    private $payload;
    
    public function __construct($request)
    {
        $this->payload = $request;
    }

    public static function make($request)
    {
        return new self($request);
    }

    public function getListInventory()
    {
        return StockManagement::make($this->payload)->listStock();
    }
}