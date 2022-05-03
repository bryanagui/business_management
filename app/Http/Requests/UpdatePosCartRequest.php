<?php

namespace App\Http\Requests;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePosCartRequest extends FormRequest
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
            'quantity' => 'required|numeric|min:1|max:' . Product::where('id', Cart::where('id', $this->id)->pluck('product_id')->first())->pluck('stock')->first() - Cart::where('product_id', Cart::where('id', $this->id)->pluck('product_id')->first())->sum('quantity'),
        ];
    }
}
