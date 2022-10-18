<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QualityHealthSafetyRequest extends FormRequest
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
            'designation' => 'required',
            'region' => 'required',
            // 'location' => 'required',
            // 'event_date' => 'required',
            // 'event_reporting_date' => 'date|required',
            // 'event_supervisor' => 'required',
            // 'detailed_event_report' => 'required',
            // 'insurance_company' => 'required',
            // 'claim_details'=>'required',
            // 'claim_category'=>'required',
            // 'claim_amount' => 'required',
            // 'cheque_title'=>'required',
            // 'cheque_number'=>'required|max:9',
            // 'cheque_number'=>'required|numeric',
            // 'cheque_date' =>'date'
        ];
    }
}
