<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemsAddonRequest extends FormRequest
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
            'item_id' => 'sometimes|exists:items,id',
            'description' => 'sometimes|string|max:255',
            'price_usd' => 'sometimes|numeric|min:0',
            'price_afg' => 'sometimes|numeric|min:0',
            'quantity' => 'sometimes|integer',
            'date' => 'sometimes|date',
        ];
    }
}
