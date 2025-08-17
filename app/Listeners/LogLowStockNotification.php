<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NotifyLowStockToAdmin;
use Throwable;

class LogLowStockNotification
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
            dd($e);
        }
    }
}
