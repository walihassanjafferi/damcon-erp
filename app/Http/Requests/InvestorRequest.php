<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestorRequest extends FormRequest
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
        return [
            'name'=>'required',
            'description'=>'required',
            'type_of_invester'=>'required',
            'contact_no'=>'required',
            'status'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'contact_no.digits' => 'contact no must be numeric and 11 digits',
        ];

    }
}
