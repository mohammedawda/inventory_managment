<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'location'    => $this->location,
            'total_items' => $this->whenLoaded('stock', function () {
                return $this->stock->sum('quantity');
            }),
            'unique_products' => $this->whenLoaded('stock', function () {
                return $this->stock->count();
            }),
            'stock' => StockResource::collection($this->whenLoaded('stock')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
