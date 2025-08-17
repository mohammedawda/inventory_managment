<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory, HasFilter;

    protected array $filterable = ['warehouse_id', 'inventory_item_id'];
    protected $fillable = ['warehouse_id', 'inventory_item_id', 'quantity', 'min_stock_level'];
    protected $casts = [
        'quantity' => 'integer',
    ];
    /* ============================== relations ============================== */
    public function warehouse() { return $this->belongsTo(Warehouse::class); }
    public function item()      { return $this->belongsTo(InventoryItem::class, 'inventory_item_id'); }
    /* ============================== functions ============================== */
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_stock_level;
    }
     /**
     * Format updated_at as Y-m-d H:i:s
     */
    public function getUpdatedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    /**
     * Format created_at as Y-m-d H:i:s
     */
    public function getCreatedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }
}
