<?php

namespace App\Http\Requests\Api\Shop\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string',
            'category' => 'nullable|string',
        ];
    }
}
