<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierPaymentRequest extends FormRequest
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
            "po_id"           => "required|numeric",
//            "supplier_type"   => "required|max:10",
            "payment_method"  => "required|string",
            "bank_id"         => "required|numeric",
            "cheque_title"    => "required",
            "cheque_number"   => "required",
            "date"            => "required|date",
            "amount"          => "required",
            // "payment_details" => "required|max:100",
            "comments"        => "required"
        ];
    }
}
