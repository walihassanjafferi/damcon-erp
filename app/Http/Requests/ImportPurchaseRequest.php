<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportPurchaseRequest extends FormRequest
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
            //
            // required|digits:13
            'title'=>'required',
            'supplier_name'=>'required',
            // 'supplier_ntn_number'=>'required',
            // 'supplier_strn_number'=>'required',
            // 'invoice_no'=>'required',
            'tax_id'=>'required',
            'taxation_month'=>'required',
            // 'tax_body_percentage'=>'required|numeric',
            'date'=>'required|date',
            'sending_bank'=>'required|different:cash_receiving_bank',
            'cash_receiving_bank'=>'required|different:sending_bank',
            'sending_amount'=>'required|numeric|min:1',
            'cash_receiving_amount'=>'required|numeric|min:1',
            'sales_tax_withheld_at_source_per'=>'required|numeric',
            'supplier_withheld_tax_1_deduction_per'=>'required|numeric',
            'damcon_gain_percentage'=>'required|numeric',
            'comments'=>'required',  
            'item_name.*'=>'required',
            'item_quantity.*'=>'required',
            'item_cost.*'=>'required'        

        ];
    }
    // public function messages()
    // {
    //     return [
    //         'title.required' => 'A title is required',
    //         'body.required' => 'A message is required',
    //     ];
    // }
}
