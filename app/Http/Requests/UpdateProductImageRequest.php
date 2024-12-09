<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductImageRequest extends FormRequest
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
            'product_id' => 'nullable|integer|exists:products,id',
            'image_url' => 'nullable|array|min:1',
            'image_url.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240', 
            'description' => 'nullable|string|max:255',
        ];
    }
}
