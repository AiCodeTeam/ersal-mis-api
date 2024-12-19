<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemsAddonRequest extends FormRequest
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
    
    public function rules()
    {
        return [
            'item_id' => 'required|exists:items,id',
            'description' => 'required|string|max:255',
            'price_usd' => 'required|numeric|min:0',
            'price_afg' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1', // Ensure quantity is at least 1
            'bill_image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048', // Make bill_image optional
            'date' => 'required|date',
        ];
    }
}
