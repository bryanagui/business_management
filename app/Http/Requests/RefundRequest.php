<?php

namespace App\Http\Requests;

use App\Models\TransactionHistory;
use Illuminate\Foundation\Http\FormRequest;

class RefundRequest extends FormRequest
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
            'quantity' => 'required|numeric|min:1|max:' . TransactionHistory::where('id', $this->id)->where('transaction_id', $this->tid)->pluck('quantity')->first() - TransactionHistory::where('id', $this->id)->where('transaction_id', $this->tid)->pluck('refunded')->first(),
        ];
    }
}
