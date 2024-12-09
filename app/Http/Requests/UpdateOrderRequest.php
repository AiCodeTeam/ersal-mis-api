<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'customer_id' => 'nullable|exists:customers,id', // Assumes there is a 'customers' table
            'user_id' => 'nullable|exists:users,id',       // Assumes there is a 'users' table
            'product_id' => 'nullable|exists:products,id', // Assumes there is a 'products' table
            'quantity' => 'nullable|integer|min:1',
            'date' => 'nullable|date',
            'price_usa' => 'nullable|numeric|min:0',
            'price_afn' => 'nullable|numeric|min:0',
            'item_id' => 'nullable|integer',
        ];
    }
}
