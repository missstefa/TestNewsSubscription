<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'unique:users, email'],
            'password' => ['required', 'string']
        ];
    }
}
