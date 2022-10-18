<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        return [
            'name' => 'required|regex:/^[A-Za-z\s-_]+$/|min:3|max:220',
            'address' => 'required|min:3|max:220',
            // 'street' => 'required|min:1|max:50',
            // 'state' => 'required|string|min:2|max:30',
            // 'city' => 'required|min:2|max:30',
            // 'Country' => 'required|min:2|max:75',
            // 'zipcode' =>'required|integer|digits_between:5,11',
            // 'cp1_name' => 'required|regex:/^[A-Za-z\s-_]+$/|min:3|max:150',
            // 'cp1_phone'=>'required|numeric|digits_between:10,15',
            // 'cp1_phone'=>'required',
            // 'cp1_cell'=>'required',
            // 'cp1_email' => 'required|email',
            // 'cp1_fax' => 'required',
            // 'cp2_name'=>'required|regex:/^[A-Za-z\s-_]+$/|min:3|max:150',
            // 'cp2_phone'=>'required',
            // 'cp2_cell'=>'required',
            // 'cp2_email' => 'required|email',
            // 'cp2_fax' => 'required',
            // 'ntn_no'=>'required',
            // 'strn_no'=>'required',
            // 'status'=>'required'
        ];
    }

     public function messages()
    {
        return [
            
            'cp1_phone.required' => 'Invalid phone number',
            'cp2_phone.required' => 'Invalid phone number',
            'cp1_cell.required' => 'Invalid cell number',
            'cp2_cell.required' => 'Invalid cell number',
            'cp1_email.required' => 'Invalid Email',
            'cp2_email.required' => 'Invalid Email',
            'ntn_no.digits' => 'NTN must be a numeric value & 7 digits',
            'strn_no.digits' => 'STRN must be a numeric value & 13 digits',


        ];
    }
}
