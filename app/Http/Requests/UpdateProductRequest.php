<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
             'name' => 'nullable|string|max:255',
             'price' => 'nullable|integer|min:1',
             'product_category_id' => [
                 'nullable',
                 Rule::exists('categories', 'id')->where(function ($query) {
                     $query->whereNull('deleted_at'); // If soft deletes are used on categories
                 }),
             ],
             'quantity' => 'nullable|string',
             'description' => 'nullable|string|max:1000',
         ];
     }
     
    
}
