<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxBodyRequest extends FormRequest
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
              "name"              => "required",
              "sale_tax_item"     => "required|numeric|digits_between:1,14",
              "sale_tax_services" => "required|numeric|digits_between:1,14",
              "source_percentage" => "required|numeric|digits_between:1,14",
              "modification_date" => "required|date",
              "comments"          => "required"
        ];
    }
}
