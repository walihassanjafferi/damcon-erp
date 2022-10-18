<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DamconAssetSalesRequest extends FormRequest
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
            "asset_id"             => "required|numeric",
            "asset_brand"          => "required",
            "model"                => "required",
            "registration_number"  => "required",
            "engine_name"          => "required",
            "chassis_number"       => "required",
            "color"                => "required",
            "engine_capacity"      => "required",
            "milage"               => "required",
            "last_milage_hours"    => "required",
            // "purchase_price"       => "required",
            // "asset_last_price"     => "required",
            "date_of_purchase"     => "required|date",
            "bank_id"              => "required|numeric",
            "cheque_no"            => "required",
            "sale_price"           => "required",
//            "specifications_1"     => "required",
//            "specifications_2"     => "required",
//            "description_input"    => "required",
//            "sold_party_details"   => "required",
            "comments"             => "required|max:5000",
        ];
    }
}
