<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvanceHrRequest extends FormRequest
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
            "employee_cnic" => "required",
            "emp_name" => "required",
            "employee_id" => "required",
            "father_name" => "required",
            "joining_date" => "required|date",
            "designation" => "required",
            "region" => "required",
            "location" => "required",
            "category_id" => "required|integer",
            "amount" => "required|numeric",
            "comments" => "max:5000",
            "description" => "required|max:5000",
            "advance_type" => "required",
            "payment_id" => "required",
            "payment_mode" => "required",
            "bank_account" => "required",
            "cheque_title" => "required|max:250",
            "cheque_number" => "required",
            "date" => "required|date",
        ];
    }
}
