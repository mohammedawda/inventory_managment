<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use App\Models\InventoryItem;
use App\Models\Warehouse;

class LowStockDetected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Warehouse $warehouse,
        public InventoryItem $item,
        public int $quantity
    ) {}
}
