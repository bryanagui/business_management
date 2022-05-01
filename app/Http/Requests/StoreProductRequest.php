<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $categories = \App\Models\ProductCategory::pluck('name')->all();
        return [
            'category' => ['required', Rule::in($categories)],
            'name' => 'required',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'stock' => 'required|numeric',
            'media' => 'nullable|mimes:jpg,jpeg,png'
        ];
    }
}
