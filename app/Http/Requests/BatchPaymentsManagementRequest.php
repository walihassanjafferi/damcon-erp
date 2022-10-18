<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatchPaymentsManagementRequest extends FormRequest
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
            "title"           => "required",
            "batch_id"        => "required",
            "date_of_cheque"  => "required|date",
            "bank_of_batch"   => "required",
            "amount"          => "required",
            "cheque_title"    => "required",
            "cheque_number"   => "required",
        ];
    }
}
