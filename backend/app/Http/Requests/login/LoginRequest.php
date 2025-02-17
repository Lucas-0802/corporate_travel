<?php

namespace App\Http\Requests\login;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/',
                'regex:/[0-9]/'
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'please_provide_your_email',
            'email.email' => 'the_provided_email_is_not_valid_please_check_and_try_again',
            'password.required' => 'password_is_required_please_enter_your_password_to_continue',
            'password.min' => 'password_must_be_at_least_8_characters_long',
            'password.regex' => 'password_must_contain_at_least_one_letter_and_one_number',
        ];
    }
}
