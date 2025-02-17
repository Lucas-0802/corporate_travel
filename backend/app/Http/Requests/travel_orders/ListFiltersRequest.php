<?php

namespace App\Http\Requests\travel_orders;

use Illuminate\Foundation\Http\FormRequest;

class ListFiltersRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge($this->query());
    }

    public function rules(): array
    {
        return [
            'status_id' => 'nullable|integer|exists:travel_order_status,id',
            'origin' => 'nullable|string',
            'destination' => 'nullable|string',
            'departure_date' => 'nullable|date',
            'return_date' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'status_id.integer' => 'status_must_be_an_integer',
            'status_id.exists' => 'status_does_not_exist',
            'origin.string' => 'origin_must_be_a_string',
            'destination.string' => 'destination_must_be_a_string',
            'departure_date.date' => 'departure_date_must_be_a_valid_date',
            'return_date.date' => 'return_date_must_be_a_valid_date',
        ];
    }
}
