<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerInvoice extends FormRequest
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
            'invoice_number' => 'required|min:1|max:200',
            'title' => 'required|min:1|max:250',
            'date_of_invoicing' => 'required|date',
            'detail_of_invoice' => 'required|min:1|max:800',
            'customer_po_id' => 'required',
            'po_balance' => 'required',
            'customer_name' => 'required',
            'region' => 'required',
            'tax_id' => 'required',
            'tax_body_description' => 'required|min:1|max:5000',
            'tax_body_percentage' => 'required',
            'penality_deduction_amount' => 'required|numeric',
            'penality_deduction_comment' => 'required|min:1|max:5000',
            'sales_tax_source_percentages' => 'required|numeric',
            'after_tax_deduction' => 'required|numeric',
            'withhold_tax1_percentage' => 'required|numeric',
            'withhold_tax2_percentage' => 'required|numeric',
            'item_name.*'=>'required|max:255',
            'item_quantity.*'=>'required',
            'item_cost.*'=>'required' ,
            'project_id'=>'required',
            'document_file' => 'array',
            'document_file.*' => 'max:1000|mimes:pdf,png,jpg,jpeg'    
        ];
    }
}
