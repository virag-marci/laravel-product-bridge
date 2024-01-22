<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['required', 'string'],
            'price' => ['required', 'decimal:2'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.max' => 'Title must be less than 255 characters',
            'description.required' => 'Description is required',
            'description.string' => 'Description must be a string',
            'image.required' => 'Image is required',
            'image.string' => 'Image must be a string',
            'price.required' => 'Price is required',
            'price.decimal' => 'Price must be a decimal',
        ];
    }
}
