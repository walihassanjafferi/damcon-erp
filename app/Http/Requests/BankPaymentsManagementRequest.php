<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankPaymentsManagementRequest extends FormRequest
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
            "expense_type"     => "required|numeric",
            "project_id"       => "required|numeric",
            "payment_date"     => "required|date",
            "payment_type"     => "required",
            // "region"           => "required|max:50",
            "amount"           => "required",
            // "paid_to_person"   => "required|max:50",
            "comments"         => "required|max:5000",
        ];
    }
}
