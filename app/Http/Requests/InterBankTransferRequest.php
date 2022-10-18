<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InterBankTransferRequest extends FormRequest
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
            // |regex:/^[A-Za-z\s-_]+$/
            'title_of_transfer'=>'required',
            'sender_bank_id'=>'required|different:receiver_bank_id',
            'receiver_bank_id'=>'required|different:sender_bank_id',
            // 'transaction_date'=>'required|date',
            'transaction_type'=>'required',
            'cheque_no'=>'required',
            'amount'=>'required|numeric',
            'comments'=>'required'
        ];
    }
}
