<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogLowStockNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // In real life, dispatch a Mailable/Notification.
        Log::warning('Low stock detected', [
            'warehouse_id'   => $event->warehouse->id,
            'warehouse_name' => $event->warehouse->name,
            'item_id'        => $event->item->id,
            'quantity'       => $event->quantity,
        ]);
    }
}
