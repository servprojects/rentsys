<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalStoreRequest extends FormRequest
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
            'expected_pickup_datetime' => 'required',
            'expected_return_datetime' => 'required',
            'actual_pickup_datetime' => 'nullable',
            'actual_return_datetime' => 'nullable',
            'date_of_inquiry' => 'nullable',
            'is_from_ads' => 'nullable',
            'pickup_remarks' => 'nullable',
            'return_remarks' => 'nullable',
            'surrendered_id' => 'nullable',
            'asset_id' => 'required',
            'client'=> 'required',

        ];
    }
}
