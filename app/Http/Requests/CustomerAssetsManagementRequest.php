<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerAssetsManagementRequest extends FormRequest
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
              "asset_item_id"          => "required",
              "customer_id"            => "required|numeric",
              "project_id"             => "required|numeric",
              "date_of_handover"       => "required|date",
            //   "item_condition"         => "required|max:20",
              "asset_incharge_id"      => "required",
            //   "asset_brand"            => "required|max:20",
            //   "model"                  => "required|max:20",
            //   "registration_number"    => "required",
            //   "engine_name"            => "required",
            //   "chassis_number"         => "required",
            //   "color"                  => "required|max:20",
            //   "engine_capacity"        => "required",
              "milage"                 => "required",
              "asset_Location"         => "required",
              "market_price"           => "required",
//              "specifications_1"       => "required",
//              "specifications_2"       => "required",
//              "description_input"      => "required",
              "comments"               => "required|max:5000",
        ];
    }
}
