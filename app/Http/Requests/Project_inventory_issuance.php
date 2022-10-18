<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Project_inventory_issuance extends FormRequest
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
            'date_of_issuance' => 'required|date',
            // 'title' => 'required|max:200',
            'project_id' => 'required',
            'issued_person_id' => 'required',
            'region' => 'required',
            'comments' => 'required',
            'item_name.*' => 'required',
            'item_quantity.*' => 'required',
            'item_cost.*' => 'required',
            'issued_person_id'=>'required'      
        
        ];
    }
}
