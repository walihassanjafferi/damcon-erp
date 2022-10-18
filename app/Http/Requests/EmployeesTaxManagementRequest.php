<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeesTaxManagementRequest extends FormRequest
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
            "title"                           => "required|max:50",
            "law_of_tax"                      => "required|max:100",
            "law_of_tax_update_date"          => "required|date",
            "income_tax_percentage_on_salary" => "required|numeric|digits_between:1,14",
            "EOBI_tax_percentage"             => "required|numeric|digits_between:1,14",
            "description_input"               => "required",
            "details_input"                   => "required"
        ];
    }
}
