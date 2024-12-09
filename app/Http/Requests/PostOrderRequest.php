<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostOrderRequest extends FormRequest
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
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'price_usa' => 'required|numeric|min:0',
            'price_afn' => 'required|numeric|min:0',
            'item_id' => 'required|integer',
        ];
    }
}
