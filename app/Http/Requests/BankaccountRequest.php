<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankaccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // |digits:14
        return [
            'name' => 'required|required',
            'title' => 'required|required',
            //|regex:/^[A-Za-z\s-_]+$/|min:3|max:250
            // "account_number" => 'required',
            'current_balance'=>'required|numeric',
            'overdraft_facility'=>'required',
            'overdraft_used'=>'numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Bank name should be alphabetic',
            'title.regex' => 'Bank title should be alphabetic',
        ];

    }
}
