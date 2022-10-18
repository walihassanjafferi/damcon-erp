<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierPORequest extends FormRequest
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
              "purchase_od_number"        => 'required',
            //   "grm_number"                => 'required|min:2|max:20',
              "type"                      => 'required|numeric',
              "supplier_id"               => 'required|numeric',
            //   "requesting_person"         => 'required|min:1|max:50',
            //   "issue_date"                => 'required|date',
            //   "items_delivery_date"       => 'required|date',
            //   "payment_terms"             => 'required',
            //   "pr_number"                 => 'required',
              "tax_body"                  => 'required|numeric',
              "taxation_month"            => 'required',
              "tax_body_percentage"       => 'required|numeric',
              "sales_tax_wh"              => 'required|numeric',
              "tax_deduction_1"           => 'required|numeric',
              "tax_deduction_2"           => 'required|numeric',
              "item_name.*"               => 'required',
              "item_quantity.*"           => 'required',
              "item_cost.*"               => 'required',
              "comments"                  => 'required'
        ];
    }

    public function messages()
    {
        return[
            'item_name.*.required' => 'Item Name is Required',
            'item_cost.*.required' => 'Item Cost is Required',
            'item_quantity.*.required' => 'Item Qty is Required',
            'grm_number.required' => 'GRM Number is Required',
        ];
    }
}
