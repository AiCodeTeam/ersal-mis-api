<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductImageRequest extends FormRequest
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
            'product_id' => 'required|integer|exists:products,id',
            'image_url' => 'required|array|min:1', // Ensure it's an array and at least one image
            'image_url.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240', // Each file should be an image with a max size of 10MB
            'description' => 'nullable|string|max:255',
        ];
    }
}
