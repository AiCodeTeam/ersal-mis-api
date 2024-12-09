<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExpenseRequest extends FormRequest
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
            'details' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',  // Changed from 'integer' to 'numeric' to allow decimal values
            'date' => 'nullable|date',
            'expense_categories_id' => [
                'nullable',
                Rule::exists('expense_categories', 'id')->where(function ($query) {
                    $query->whereNull('deleted_at');
                })
            ],
            'user_id' => 'nullable|exists:users,id',
            'purchased_by' => 'nullable|string|max:255',
        ];
    }
    
}