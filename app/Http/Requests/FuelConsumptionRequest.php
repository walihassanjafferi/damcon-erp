<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuelConsumptionRequest extends FormRequest
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
            'title_po_number'=>'required', 
            'project_id' => 'required',
            // 'date_of_entry' => 'date|required',
            // 'entry_person' => 'required|max:70',
            // 'driver_person'=> 'required|max:70',
            'fueling_item_id'=>'required',
            'fuel_item_code'=>'required',
            'supplier_id'=>'required',
            'consumption_month'=>'required',
            'quantity_in_liter'=>'required|numeric',
            'amount_with_sale_tax'=>'required',
            'rate_fuel_per_liter'=>'required|numeric',
            'milage_hours'=>'required|numeric',
            'oil_filter_due_date'=>'required|numeric',
            'tax_body_id'=>'required',
            'taxation_month'=>'required|date',
            'tax_body_percentage'=>'required',
            'comments'=>'required',
            'sales_tax_withheld_at_source_per'=>'required|numeric',
            'supplier_withheld_tax_1_deduction_per'=>'required|numeric',

          
        ];
    }
    public function messages()
    {
        return [
            'supplier_withheld_tax_1_deduction_per.required' => 'A Sales Tax Withheld at Source Percentage is required',
            'Supplier withheld Tax 1 Deduction Percentage.required' => 'A Supplier withheld Tax 1 Deduction Percentage is required',
        ];
    }
}
