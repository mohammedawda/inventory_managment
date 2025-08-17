<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Repositories\TransferRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_transfer_more_than_available_stock()
    {
        $warehouseA = Warehouse::factory()->create();
        $warehouseB = Warehouse::factory()->create();
        $item       = InventoryItem::factory()->create();
        dd(User::first());
        $this->postJson('/api/login', [
            (User::first())->email,
            '123456'
        ]);
        // Only 5 units available
        Stock::factory()->create([
            'warehouse_id'      => $warehouseA->id,
            'inventory_item_id' => $item->id,
            'quantity'          => 5,
        ]);

        $service = app(TransferRepository::class);

        $this->expectException(ValidationException::class);

        $request = new Request();
        $request->merge([
            'from_warehouse_id' => $warehouseA->id,
            'to_warehouse_id'   => $warehouseB->id,
            'inventory_item_id' => $item->id,
            'quantity'          => 10,
        ]);
        $service->store($request); // request more than available
    }
}
