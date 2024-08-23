<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
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
            'name' => 'required',
            'code' => 'required',
            'address' => 'nullable',
            'contact_number' => 'nullable',
            'email' => 'nullable',
            'country_code' => 'nullable',
            'region_code' => 'nullable',
            'municipality_code' => 'nullable',
            'location_coordinates' => 'nullable',
        ];
    }
}
