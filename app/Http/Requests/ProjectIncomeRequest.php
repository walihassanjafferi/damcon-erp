<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectIncomeRequest extends FormRequest
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
            'project_id' => 'required',
            'cheque_receving_date'=>'date|required',
            'received_cheque_bank'=>'required',
            'cheque_clearing_date'=>'date|required',
            'cheque_number'=> 'required|min:1',
            'cheque_amount'=> 'required|numeric',
            'cash_deposit_bank_id'=>'required',
            'difference_comments'=>'required',
            'document_file' => 'array',
            'document_file.*' => 'max:1000|mimes:pdf,png,jpg,jpeg'   
        ];
    }
}
