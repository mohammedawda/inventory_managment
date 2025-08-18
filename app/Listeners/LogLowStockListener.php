<?php

namespace App\Listeners;

use Throwable;
use App\Models\User;
use App\Notifications\NotifyLowStockToAdmin;

class LogLowStockListener
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
        try {
            $admin = User::where('role', User::ADMIN)->first();
            $admin->notify(new NotifyLowStockToAdmin($event));
        } catch(Throwable $e) {
            throw $e;
        }
    }
}
