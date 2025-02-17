<?php

namespace App\Http\Requests\travel_orders;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'origin' => 'required|string',
            'destination' => 'required|string',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:departure_date',
        ];
    }

    public function messages()
    {
        return [
            'origin.required' => 'please_provide_the_trip_origin',
            'origin.string' => 'origin_must_be_a_string',
            'destination.required' => 'please_provide_the_trip_destination',
            'destination.string' => 'destination_must_be_a_string',
            'departure_date.required' => 'please_provide_the_departure_date',
            'departure_date.date' => 'departure_date_must_be_a_valid_date',
            'return_date.required' => 'please_provide_the_return_date',
            'return_date.date' => 'return_date_must_be_a_valid_date',
        ];
    }
}
