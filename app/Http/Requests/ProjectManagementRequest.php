<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectManagementRequest extends FormRequest
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
            'name'=>'required',
            'project_code'=>'required',
            'customer_id'=>'required',
            // 'project_description'=>'required|max:400',
            // 'customer_project_manager_name'=>'required|max:40',
            // 'customer_project_manager_contact_no'=>'required',
            // 'damcon_project_manager_name'=>'required|max:100',
            // 'damcon_project_manager_contact_no'=>'required',
            'project_start_date'=>'required|date',
            'project_end_date'=>'required|date',
            'status'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'customer_project_manager_name.required' => 'Customer PM name required',
            'damcon_project_manager_name.required' => 'Damcon PM name required',
            'customer_project_manager_contact_no.required' => 'Customer PM contact no required',
            'damcon_project_manager_contact_no.required' => 'Damcon PM contact no required',

        ];

    }
}
