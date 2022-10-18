<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DamconAssetDepreciationRequest extends FormRequest
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
            "asset_id"                  => "required|numeric",
            "date_of_purchase"          => "required|date",
            "asset_brand"               => "required|max:250",
            "model"                     => "required|max:250",
            "registration_number"       => "required|max:250",
            "engine_name"               => "required|max:250",
            "chassis_number"            => "required|max:250",
            "color"                     => "required|max:250",
            "engine_capacity"           => "required|max:250",
            "milage"                    => "required|max:250",
            "current_milage_hours"      => "required|max:250",
            "purchase_price"            => "required",
            "asset_new_price"           => "required",
            "asset_last_price"          => "numeric",
            "date_of_depreciation"      => "required|date",
            "last_date_of_depreciation" => "date",
//            "specifications_1"     => "",
//            "specifications_2"     => "",
//            "description_input"    => "",
            "comments"                  => "required"
        ];
    }
}
