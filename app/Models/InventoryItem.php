<?php

namespace App\Models;

use App\Traits\HasSort;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends Model
{
    use HasFilter, HasSort, HasFactory;

    protected $filterBetween    = ['price' => ['from' => 'price_from', 'to' => 'price_to']];
    protected $searchable       = ['name'];

    protected $fillable = ['name', 'sku', 'price'];
    protected $casts    = [
        'metadata' => 'array',
        'price' => 'decimal:2',
    ];

    /* ============================== relations ============================== */
    public function stocks()     { return $this->hasMany(Stock::class); }
    public function warehouses() { return $this->belongsToMany(Warehouse::class, 'stock')->withPivot('quantity')->withTimestamps(); }
    /* ============================== functions ============================== */
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
