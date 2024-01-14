<?php

namespace App\Http\Requests\Api\Shop\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'date_and_time' => 'required|string',
            'description' => 'required|string',
            'images.*' => 'required|image|mimes:jpg,jpeg,img,png'
        ];
    }
}
