<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuelitemRequest extends FormRequest
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
            'item_code'=>'required|max', 
            'item_name' => 'required|max',
            'project_id' => 'required',
            'supplier_id' => 'required',
            'current_balance_item' => 'required|numeric',
            'current_stock_cost' => 'required|numeric',
            'fuel_type' => 'required',
            'fuel_card_no' => 'required',
            'date_of_addition' => 'required|date',
            'monthly_limit'=>'required',
            'comments'=>'required|max:1000',
        ];
    }
}