<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends FormRequest
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
        $types = \App\Models\RoomType::pluck('type')->all();
        return [
            'number' => 'required|unique:rooms',
            'type' => ['required', Rule::in($types)],
            'floor' => 'required|numeric|min:1|max:30',
            'rate' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'nullable',
            'media' => 'nullable|mimes:jpg,jpeg,png'
        ];
    }
}
