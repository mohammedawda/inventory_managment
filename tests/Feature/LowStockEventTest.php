<?php

namespace Tests\Feature;

use App\Events\LowStockDetected;
use Tests\TestCase;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

class LowStockEventTest extends TestCase
{
    // use RefreshDatabase;

    public function test_low_stock_event_is_dispatched()
    {
        Event::fake();

        $user       = User::factory()->create();
        $user->role = 1;
        $user->save();

        $warehouse  = Warehouse::factory()->create();
        $item       = InventoryItem::factory()->create();

        Stock::create([
            'warehouse_id'      => $warehouse->id,
            'inventory_item_id' => $item->id,
            'quantity'          => 10,
            'min_stock_level'   => 10,
        ]);
        $this->actingAs($user, 'sanctum');
        $response = $this->postJson('/api/stock-transfers', [
            'from_warehouse_id' => $warehouse->id,
            'to_warehouse_id'   => Warehouse::factory()->create()->id,
            'inventory_item_id' => $item->id,
            'user_id'           => $user->id,
            'quantity'          => 1,
        ]);
        Event::assertDispatched(LowStockDetected::class);
        $response->assertStatus(201);
    }
}
