<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanPaymentRequest extends FormRequest
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
             "title"           => "required",
             "investor_id"     => "required|numeric",
             "payment_type"    => "required|numeric",
            //  "project_id"      => "required|numeric",
             "bank_id"         => "required|numeric",
             "cheque_title"    => "required",
             "cheque_number"   => "required",
             "date"            => "required|date",
             "amount"          => "required|numeric",
             "payment_details" => "required",
             "comments"        => "required",
        ];
    }
}
