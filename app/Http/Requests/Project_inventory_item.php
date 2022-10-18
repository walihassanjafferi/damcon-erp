<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Project_inventory_item extends FormRequest
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
            //
            'item_code'=>'required|unique:project_items_inventories,item_code', 
            'item_name' => 'required',
            'projects' => 'required',
            'suppliers' => 'required',
            'current_balance_item' => 'required|numeric',
            'current_stock_cost' => 'required|numeric',
            // 'item_brand' => 'required|max:50',
            // 'unit_of_measure' => 'required|max:10',
            // 'date_of_addition' => 'required|date',
            'description'=>'required|max:2000',
            'comments'=>'required|max:2000',
            
        ];
    }

    public function messages(){
        return [
            'category_id.required' => 'The Category name field is required',
        ];
    }
}
