<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockTransferFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_stock_transfer()
    {
        $warehouseA = Warehouse::factory()->create();
        $warehouseB = Warehouse::factory()->create();
        $item       = InventoryItem::factory()->create();

        Stock::create([
            'warehouse_id'      => $warehouseA->id,
            'inventory_item_id' => $item->id,
            'min_stock_level'   => rand(1, 5),
            'quantity'          => 20,
        ]);

        $payload = [
            'from_warehouse_id' => $warehouseA->id,
            'to_warehouse_id'   => $warehouseB->id,
            'inventory_item_id' => $item->id,
            'quantity'          => 5,
        ];

        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/stock-transfers', $payload);
        $response->assertStatus(201)
                 ->assertJson(['message' => 'Stock transfer completed successfully.']);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id'      => $warehouseA->id,
            'inventory_item_id' => $item->id,
            'quantity'          => 15, // reduced
        ]);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id'      => $warehouseB->id,
            'inventory_item_id' => $item->id,
            'quantity'          => 5, // added
        ]);
    }
}
