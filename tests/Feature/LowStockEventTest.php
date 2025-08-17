<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use App\Events\LowStockDetected;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LowStockEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_low_stock_event_is_dispatched()
    {
        Event::fake();

        $warehouse = Warehouse::factory()->create();
        $item      = InventoryItem::factory()->create();

        // Create low stock inventory
        Stock::factory()->create([
            'warehouse_id'      => $warehouse->id,
            'inventory_item_id' => $item->id,
            'quantity'          => 20,
        ]);

        // Simulate a transfer that drops stock further
        $this->postJson('/api/stock-transfers', [
            'from_warehouse_id' => $warehouse->id,
            'to_warehouse_id'   => Warehouse::factory()->create()->id,
            'inventory_item_id' => $item->id,
            'quantity'          => 1,
        ]);

        Event::assertDispatched(LowStockDetected::class);
    }
}
