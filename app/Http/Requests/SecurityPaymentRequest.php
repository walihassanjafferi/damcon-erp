<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SecurityPaymentRequest extends FormRequest
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
              "project_id"       => "required|numeric",
              "payment_type"     => "required|numeric",
              "payment_method"   => "required",
              "bank_id"          => "required|numeric",
              "cheque_title"     => "required",
              "cheque_number"    => "required",
              "date"             => "required|date",
              "amount"           => "required",
            //   "payment_details"  => "required|max:100",
            //   "customer"         => "required|max:30",
              "comments"         => "required|max:1500"
        ];
    }
}
