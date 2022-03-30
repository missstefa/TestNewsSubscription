<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexUserTopicsRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'limit' => ['nullable', 'integer', 'max:100'],
            'offset' => ['nullable', 'integer']
        ];
    }
}
