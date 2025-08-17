<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockTransfer extends Model
{
    use HasFactory, HasFilter;

    protected $filterBetween    = ['transfer_date' => ['from' => 'transfer_date_from', 'to' => 'transfer_date_to']];
    protected array $filterable = ['from_warehouse_id', 'to_warehouse_id', 'inventory_item_id'];
    protected $fillable = [
        'inventory_item_id', 'from_warehouse_id', 'to_warehouse_id', 'quantity', 'user_id', 'transfer_date',
        'notes', 'status',
    ];
    protected $casts = [
        'quantity'      => 'integer',
        'transfer_date' => 'datetime',
    ];

    /* ============================== relations ============================== */
    public function item()          { return $this->belongsTo(InventoryItem::class, 'inventory_item_id'); }
    public function fromWarehouse() { return $this->belongsTo(Warehouse::class, 'from_warehouse_id'); }
    public function toWarehouse()   { return $this->belongsTo(Warehouse::class, 'to_warehouse_id'); }
    public function user()          { return $this->belongsTo(User::class); }
}