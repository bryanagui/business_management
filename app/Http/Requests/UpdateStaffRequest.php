<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (!empty($this->birthdate)) {
            $this->merge([
                'birthdate' => (new Carbon($this->birthdate))->format("Y-m-d")
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'gender' => 'required|in:male,female',
            'address' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,' . $this->id,
            'birthdate' => 'required',
            'contact' => 'required|digits:11'
        ];
    }
}
