<?php

namespace App\Http\Requests\Api\Shop\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductBulkDeleteRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'ids' => 'required|array'
        ];
    }
}
