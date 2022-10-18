<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UninvoicedReceiveablesRequest extends FormRequest
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
            'title' => 'required',
            'date' => 'required|date',
            'project_id' => 'required',
            'month'=>'required',
            'region' => 'required',
            'tax_id' => 'required',
            'reason_of_uninvoicing' => 'required',
            'estimated_qty' => 'required|numeric',
            'estimated_unit_price' => 'required|numeric',
            'sales_tax_percentage'=>'required',
            'tax_id'=>'required',
            'tax_body_percentage'=>'required',
            'tax_type_comment' =>'required',
            'sales_tax_source_percentage'=>'required|numeric',
            'withhold_tax_percentage'=>'required|numeric',
            'wh_type_comments'=>'required',
            'document_file' => 'array',
            'document_file.*' => 'max:1000|mimes:pdf,png,jpg,jpeg'    
        ];
    }
}
