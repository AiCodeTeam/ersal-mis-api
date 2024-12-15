<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255', 
            'price' => 'required|integer|min:1', 
            'product_category_id' => 'nullable|integer|exists:categories,id',
            'quantity' => 'required|integer|min:1', 
            'description' => 'nullable|string|max:1000',
            'images' => 'nullable|array',
            'images.*.file' => 'required|file|mimes:jpeg,jpg,png,gif,webp',
        ];
    }
}
