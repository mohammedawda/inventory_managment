<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockTransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'from_warehouse' => new WarehouseResource($this->whenLoaded('fromWarehouse')),
            'to_warehouse'   => new WarehouseResource($this->whenLoaded('toWarehouse')),
            'inventory_item' => new InventoryItemResource($this->whenLoaded('inventoryItem')),
            'quantity'       => $this->quantity,
            'status'         => $this->status,
            'status_text'    => $this->status_text,
            'transfer_date'  => $this->transfer_date,
            'user'           => $this->whenLoaded('user', function () {
                return [
                    'id'    => $this->user->id,
                    'name'  => $this->user->name,
                    'email' => $this->user->email,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
