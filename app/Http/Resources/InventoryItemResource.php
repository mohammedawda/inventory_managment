<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryItemResource extends JsonResource
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
            'name'           => $this->name,
            'sku'            => $this->sku,
            'price'          => $this->price,
            'description'    => $this->description,
            'total_quantity' => $this->whenLoaded('stock', function () {
                return $this->stock->sum('quantity');
            }),
            'warehouses_count' => $this->whenLoaded('stock', function () {
                return $this->stock->count();
            }),
            'stock'      => StockResource::collection($this->whenLoaded('stock')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
