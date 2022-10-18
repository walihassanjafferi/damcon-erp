<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Maintenanace_inventory_item extends FormRequest
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
            'item_code'=>'required|unique:mainterance_items_inventories,item_code|',
            'item_name' => 'required',
            // 'service_id' => 'required',
            'category_id' => 'required',
            'projects' => 'required',
            'suppliers' => 'required',
            'current_balance_item' => 'required',
            'current_stock_cost' => 'required',
            // 'item_brand' => 'required|max:50',
            // 'unit_of_measure' => 'required|max:10',
            // 'date_of_addition' => 'required|date',
            // 'description'=>'required|max:1000',
            'comments'=>'required',
        ];
    }
}
