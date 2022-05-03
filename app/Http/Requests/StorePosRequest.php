<?php

namespace App\Http\Requests;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePosRequest extends FormRequest
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
        return [
            'id' => ['required', Rule::unique('carts', 'product_id')->where(function ($query) {
                $query->where('user_id', Auth::user()->id);
            })],
            'quantity' => 'required|numeric|min:1|max:' . Product::where('id', $this->id)->pluck('stock')->first() - Cart::where('product_id', $this->id)->sum('quantity'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id.unique' => 'The item already exists in your cart.',
        ];
    }
}
