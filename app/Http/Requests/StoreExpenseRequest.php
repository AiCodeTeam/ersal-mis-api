<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
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
            'details' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',  // Validates the price as a numeric value
            'date' => 'required|date',
            'expense_categories_id' => 'required|exists:categories,id',
            // 'user_id' => 'required|exists:users,id',
            'purchased_by' => 'required|string|max:255',
        ];
    }
    
}
