<?php

namespace App\Http\Requests;

use App\Rules\StockAvailableRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'inventory_item_id' => ['required', 'integer', 'exists:inventory_items,id'],
            'from_warehouse_id' => ['required', 'integer', 'different:to_warehouse_id', 'exists:warehouses,id'],
            'to_warehouse_id'   => ['required', 'integer', 'exists:warehouses,id'],
            'quantity'          => [
                'required', 
                'integer', 
                'min:1', 
                'max:999999999',
                new StockAvailableRule((int) $this->input('from_warehouse_id'), (int) $this->input('inventory_item_id'))
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'from_warehouse_id' => 'source warehouse',
            'to_warehouse_id'   => 'destination warehouse',
            'inventory_item_id' => 'inventory item',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'from_warehouse_id' => (int) $this->from_warehouse_id,
            'to_warehouse_id'   => (int) $this->to_warehouse_id,
            'inventory_item_id' => (int) $this->inventory_item_id,
            'quantity'          => (int) $this->quantity,
        ]);
    }
}