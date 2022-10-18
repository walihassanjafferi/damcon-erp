<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
        // regex:/^[A-Za-z\s-_]+$/
        // digits:7
        // digits:13
        return [
            //
            'name' => 'required',
            'suppliers_types_id'=>'required',
            'address' => 'required',
            // 'street' => 'required|min:1|max:50',
            // 'state' => 'required|regex:/^[A-Za-z\s-_]+$/|min:2|max:30',
            // 'city' => 'required|regex:/^[A-Za-z\s-_]+$/|min:2|max:30',
            // 'country' => 'required|regex:/^[A-Za-z\s-_]+$/',
            // 'zip_code' =>'required|integer|digits_between:5,11',
            // 'cp1_name' => 'required|min:3|max:100',
            // 'cp1_phone_no'=>'required',
            // 'cp1_cell_no'=>'required',
            // 'cp1_email' => 'required|email',
            // 'cp1_fax' => 'required',  
            // 'ntn_number'=>'required',
            // 'strn_number'=>'required',
            // 'bank_name' =>'required|max:130',
            // 'bank_account_title'=>'required|max:130',
            // 'bank_account_number'=>'required',
            // 'status'=>'required'
        ];
    }

    public function messages()
    {
        return [
            
            'cp1_phone_no.required' => 'Invalid phone number',
            'cp1_cell_no.required' => 'Invalid cell number',
            'cp1_email.required' => 'Invalid Email',
            'ntn_number.digits' => 'NTN must be a numeric value & 7 digits',
            'strn_number.digits' => 'STRN must be a numeric value & 13 digits',
            'bank_account_title.regex' =>'Bank title only allowed alphabetic characters',
            'bank_name.regex' =>'Bank name only allowed alphabetic characters'

        ];
    }
}
