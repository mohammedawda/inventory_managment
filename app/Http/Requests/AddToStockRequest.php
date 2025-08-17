<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'warehouse_id'      => ['required', 'integer', 'different:to_warehouse_id', 'exists:warehouses,id'],
            'inventory_item_id' => ['required', 'integer', 'exists:inventory_items,id'],
            'quantity'          => ['required', 'integer', 'min:1', 'max:999999999'],
            'min_stock_level'   => ['required', 'integer', 'min:0', 'max:999999999'],
        ];
    }
}
