<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Events\LowStockDetected;
use App\Listeners\LogLowStockListener;
use Illuminate\Support\Facades\Event;
class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(
            LowStockDetected::class,
            LogLowStockListener::class
        );
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
