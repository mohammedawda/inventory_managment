<?php

namespace App\Rules;

use App\Models\Stock;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StockAvailableRule implements ValidationRule
{
    protected $warehouseId;
    protected $inventoryItemId;

    public function __construct($warehouseId, $inventoryItemId)
    {
        $this->warehouseId     = $warehouseId;
        $this->inventoryItemId = $inventoryItemId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $available = Stock::where('warehouse_id', $this->warehouseId)
                     ->where('inventory_item_id', $this->inventoryItemId)
                     ->value('quantity');

        if($available == null) {
            $fail("Invalid stock or this stock may not have a target quantity");
            return;
        }

        if ($available < $value)
            $fail("Insufficient stock in source warehouse: {$available} available.");
    }
}
