<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicesPORequest extends FormRequest
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
              "title_po_number"          => 'required',
              "type"                     => 'required|numeric',
            //   "grm_number"               => 'required|min:4|max:20',
              "supplier_id"              => 'required|numeric',
            //   "requesting_person"        => 'required|string|min:2|max:20',
            //   "customer_po_number"       => 'required|max:20',
            //   "delivery_date"            => 'required|date',
            //   "isseu_date"               => 'required|date',
            //   "pr_number"                => 'required|max:20',
              "tax_body_id"              => 'required|numeric',
              "taxation_month"           => 'required',
              "sales_tax_wh"             => 'required|numeric',
              "supplier_tax_deduction_1" => 'required|numeric',
              "supplier_tax_deduction_2" => 'required|numeric',
              "item_name.*"              => 'required',
              "item_quantity.*"          => 'required',
              "item_cost.*"              => 'required',
              "comments"                 => 'required',
        ];
    }

    public function messages()
    {
        return parent::messages(); // TODO: Change the autogenerated stub
    }
}
