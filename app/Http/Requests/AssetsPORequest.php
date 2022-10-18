<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetsPORequest extends FormRequest
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
              "purchase_title"            => 'required',
              "supplier_id"               => 'required|numeric',
            //   "grm_number"                => 'required|max:20',
            //   "delivery_date"             => 'required|date',
            //   "isseu_date"                => 'required|date',
              "payment_terms"             => "required|numeric",
              "tax_body_id"               => 'required|numeric',
              "taxation_month"            => 'required',
              "tax_body_percentage"       => 'required|numeric',
              "sales_tax_wh"              => 'required|numeric',
              "supplier_tax_deduction_1"  => 'required|numeric',
              "supplier_tax_deduction_2"  => 'required|numeric',
              "item_name.*"               => 'required',
              "item_quantity.*"           => 'required',
              "item_cost.*"               => 'required',
              "comments"                  => 'required|min:1|max:5000'
        ];
    }
    public function messages()
    {
        return parent::messages(); // TODO: Change the autogenerated stub
    }
}