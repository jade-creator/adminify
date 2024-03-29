<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'identifier' => 'required|string',
            'password' => 'required|string',
            'remember' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'identifier.required' => 'The email or username is required.'
        ];
    }
}
