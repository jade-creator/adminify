<?php

namespace App\Http\Requests\Api\Shop\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'date_and_time' => 'required|string',
            'images.*' => 'required|image|mimes:jpg,jpeg,img,png'
        ];
    }
}
