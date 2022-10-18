<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveManagementRequest extends FormRequest
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

            'employee_cnic' => 'required',
            'emp_name'=>'required',
            'employee_id' => 'required',
            'father_name' => 'required',
            'joining_date' => 'required|date',
            'project_id' => 'required',
            'date' => 'required',
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'no_off_Days'=>'required',
            'leave_type'=>'required'





        ];
    }
}
