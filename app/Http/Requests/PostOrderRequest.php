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
            'customer_id' => 'nullable|exists:customers,id',
            'user_id' => 'nullable|exists:users,id',    
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'price_usa' => 'required|numeric|min:0',
            'price_afn' => 'required|numeric|min:0',
            // 'item_id' => 'required|integer',
            'ref_no' => 'required|integer'
        ];
    }
}
