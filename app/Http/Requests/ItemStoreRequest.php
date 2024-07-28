<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required|string',
            'details' => 'nullable|string',
            'model' => 'required|string',
            'item_generic_name_id' => 'required|integer',
            'item_category_id' => 'required|integer',
            'item_brand_id' => 'required|integer',
        ];
    }
}
