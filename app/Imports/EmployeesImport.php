<?php

namespace App\Imports;

use App\Models\Employeemanagement;
use App\Models\Employeebankacc;
use App\Models\employee_salarybreakdown as SBD;
use App\Models\Preallowed_leaves;
use App\Models\EmployeeReference;
use App\Models\EmployeePoliceVerification;
use App\Models\EmployeeEmergencyContact;
use App\Models\EmployeeLandlineContact;
use App\Models\EmployeeNextOfKin;
use App\Models\EmployeeDependents;
use App\Models\EmployeeQualificationDetails;
use App\Models\EmployeeWorkExperience;
use App\Models\Employeesubordinates;
use App\Models\Project;



use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EmployeesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        foreach($collection as $index=>$item)
        {
            if($index >= 1)
            {
             
                $joining_date = '';$date_of_birth = '';  $verification_date = '' ;

               $joining_date = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[9]));
               $date_of_birth = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[23]));
               $verification_date = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[47]));
               
              // dd( $joining_date , $date_of_birth ,$verification_date);
               // employee data

                // find projects

                $project_id = ''; $line_manager_id = '';
                $project_id = Project::where('project_code',$item[8])->pluck('id');
                
                $line_manager_id = Employeemanagement::where('employee_damcon_id',$item[11])->pluck('id');

               // dd($line_manager_id[0]);
            
                $employee_data = [
                    'name' => $item[0] ?? '',
                    'father_name' => $item[1] ?? '',
                    'cnic' => $item[2] ?? '',
                    'employee_damcon_id' => $item[3] ?? '',
                    'eobi_member_checkbox' => $item[4] ?? '',
                    'eobi_number' => $item[5] ?? '',
                    'social_security_member_checkbox' => $item[6] ?? '',
                    'social_security_number' => $item[7] ?? '',
                    'project_id' => $project_id[0] ?? '', 
                    'joining_date' => $joining_date ?? '',
                    'designation' => $item[10] ?? '',
                    'line_manager_employee_id' => $line_manager_id[0] ?? '',
                    'date_of_birth' => $date_of_birth ?? '',
                    'contact_no_1' => $item[13] ?? '',
                    'contact_no_2' => $item[14] ?? '',
                    'email_address_1'=> $item[15] ?? '',
                    'email_address_2'=> $item[16] ?? '',
                    'gender' => $item[17] ?? '',
                    'marital_status' => $item[18] ?? '',
                    'religion' => $item[19] ?? '',
                    'region'=> $item[20] ?? '',
                    'current_address'=>$item[21] ?? '',
                    'permanent_address'=>$item[22] ?? '',
                    'assigned_locations'=>$item[24] ?? '',
                    'form_step'=>13,
                    'completed_flag'=>1
    
                ];
    
            
                $employeeManagement = Employeemanagement::updateOrCreate(
                ['employee_damcon_id'=> $item[3]],
                $employee_data);
                
                ##adding sub ordinates
                $subordinates = isset($item[12]) ? str_replace("{","",$item[12]) : '';
                $subordinates_val = isset($subordinates) ? str_replace("}","",$subordinates) : '';
                
                $sub_value = explode(",",$subordinates_val);
                foreach($sub_value as $index=>$val)
                {
                    $employee = Employeemanagement::where('employee_damcon_id',$val)->pluck('id');
                 
                    if(count($employee))
                    {
                      
                        $insert_subordinates = new Employeesubordinates();
                        $insert_subordinates->subordinate_id = $employee[0];
                        $insert_subordinates->employee_id  =  $employeeManagement->id;
                        $insert_subordinates->save();
                    }
                  

                }

                ##adding sub ordinates end

                ##adding banking details

                $data_bank = [
                    'employeemanagement_id' => $employeeManagement->id,
                    'bank_name' => $item[26] ?? '',
                    'account_title' => $item[27] ?? '',
                    'account_number' => $item[28] ?? '',
                ];

                
                
                $emp_bank = Employeebankacc::updateOrCreate(
                    ['employeemanagement_id'=> $employeeManagement->id],
                    $data_bank
                );
                
                ##adding banking details

                ##adding salary details##

                $data_salary = [
                    'employeemanagement_id' => $employeeManagement->id,
                    'basic_salary' => $item[29] ?? '',
                    'medical_allowance' => $item[30] ?? '',
                    'mobile_allowance' => $item[31] ?? '',
                    'laptop_bonus' => $item[32] ?? '',
                    'conveyance_allowance' => $item[33] ?? '',
                    'other_allowance'=> $item[34] ?? ''
                ];

                $emp_salary = SBD::updateOrCreate(
                    ['employeemanagement_id'=> $employeeManagement->id],
                    $data_salary
                );

                ##adding salary details##


                ##preallowed leave##

                $data_preallowed_leaves = [
                    'employeemanagement_id' => $employeeManagement->id,
                    'annual_leaves' => $item[35] ?? '',
                    'casual_leaves' => $item[36] ?? '',
                    'sick_leaves' => $item[37] ?? '',
                    'off_leaves' => $item[38] ?? '' 
                ];

                $emp_preallowed_leaves = Preallowed_leaves::updateOrCreate(
                    ['employeemanagement_id'=> $employeeManagement->id],
                    $data_preallowed_leaves
                );
                   
                ##preallowed leave##


                ##reference details

                $data_refrence_details = [
                    'employeemanagement_id' => $employeeManagement->id, 
                    'reference_name_one' => $item[39] ?? '',
                    'reference_contactno_one' => $item[40] ?? '',
                    'reference_occupation_one' => $item[41] ?? '',
                    'reference_email_one'=> $item[42] ?? '',
                    'reference_name_two' => $item[43] ?? '',
                    'reference_contactno_two' => $item[44] ?? '',
                    'reference_occupation_two' => $item[45] ?? '',
                    'reference_email_two'=> $item[46] ?? '',
                ];


                $emp_refrences = EmployeeReference::updateOrCreate(
                    ['employeemanagement_id'=> $employeeManagement->id],
                    $data_refrence_details
                );

                ##reference details

                ##police verfication##

                $data_police_verification = [
                    'employeemanagement_id' => $employeeManagement->id,
                    'verification_date'=> $verification_date,
                    'status'=> $item[48] ?? '',
                    'station'=> $item[49] ?? '',
                ];

                $emp_police_verifications = EmployeePoliceVerification::updateOrCreate(
                    ['employeemanagement_id'=> $employeeManagement->id],
                    $data_police_verification
                );
                ##police verfication##


                ##emergency contact number

                $data_employee_emergency = [
                    'employeemanagement_id' => $employeeManagement->id,
                    'name_one' => $item[50] ?? '',
                    'relationship_one' => $item[51] ?? '',
                    'verification_status_one'=> $item[52] ?? '',
                    'contact_no_one'=> $item[53] ?? '',  
                    'name_two' => $item[54] ?? '',
                    'relationship_two' => $item[55] ?? '',
                    'verification_status_two'=> $item[56] ?? '',
                    'contact_no_two'=> $item[57] ?? '',  
                    'name_three' => $item[58] ?? '',
                    'relationship_three' => $item[59] ?? '',
                    'verification_status_three'=> $item[60] ?? '',
                    'contact_no_three'=> $item[61] ?? '',  

                ];


                $emp_emergency_number = EmployeeEmergencyContact::updateOrCreate(
                    ['employeemanagement_id'=> $employeeManagement->id],
                    $data_employee_emergency
                );


                ##emergency contact number


                ##landline contact number

                $data_landline_contact = [
                    'employeemanagement_id' => $employeeManagement->id,
                    'name_one' => $item[62] ?? '',
                    'relationship_one' => $item[63] ?? '',
                    'verification_status_one'=> $item[64] ?? '',
                    'contact_no_one'=> $item[65] ?? '',
                    'name_two'=> $item[66] ?? '',
                    'relationship_two'=> $item[67] ?? '', 
                    'verification_status_two'=> $item[68] ?? '',
                    'contact_no_two'=> $item[69] ?? '',
                ];


                $employee_landline_contact = EmployeeLandlineContact::updateOrCreate(
                    ['employeemanagement_id'=> $employeeManagement->id],
                    $data_landline_contact
                );
                ##landline contact number


                ## Next of kin ##

                $data_employee_kin = [
                    'employeemanagement_id' => $employeeManagement->id,
                    'name_one' => $item[70] ?? '',
                    'cnic_one' => $item[71] ?? '',
                    'relationship_one' => $item[72] ?? '',
                    'verification_status_one'=> $item[73] ?? '',
                    'contact_no_one'=> $item[74] ?? '',
                    'name_two'=> $item[75] ?? '',
                    'cnic_two' => $item[76] ?? '',
                    'relationship_two'=> $item[77] ?? '', 
                    'verification_status_two'=> $item[78] ?? '',
                    'contact_no_two'=> $item[79] ?? '',
                ];

                $employee_kins = EmployeeNextOfKin::updateOrCreate(
                    ['employeemanagement_id'=> $employeeManagement->id],
                    $data_employee_kin
                );
                
                ##Next of kin##


                ##Dependents##

                $data_emp_dependents = [
                    'employeemanagement_id' => $employeeManagement->id,
                    'name_one' => $item[80] ?? '',
                    'dob_one' => $item[81] ?? '',
                    'relationship_one' => $item[82] ?? '' ,
                    'contact_no_one' => $item[83] ?? '',
                    'name_two' => $item[84] ?? '',
                    'dob_two' => $item[85] ?? '',
                    'relationship_two' => $item[86] ?? '',
                    'contact_no_two' => $item[87] ?? '',
                    'name_three' => $item[88] ?? '',
                    'dob_three' => $item[89] ?? '',
                    'relationship_three' => $item[90] ?? '',
                    'contact_no_three' => $item[92] ?? '',
                    'name_four' => $item[93] ?? '',
                    'dob_four' => $item[94] ?? '',
                    'relationship_four' => $item[95] ?? '',
                    'contact_no_four' => $item[96] ?? '',
                    'name_five' => $item[97] ?? '',
                    'dob_five' => $item[98] ?? '',   
                    'relationship_five' => $item[99] ?? '',   
                    'contact_no_five' => $item[100] ?? '',   

                ];

                ##Dependents##


                ##qualifications##

                $data_employee_qualifications = [
                    'employeemanagement_id' => $employeeManagement->id,
                    'program_one' => $item[101] ?? '',
                    'passing_year_one' => $item[102] ?? '',
                    'marks_percentage_one' => $item[103] ?? '',
                    'program_two' => $item[104] ?? '',
                    'passing_year_two' => $item[105] ?? '',
                    'marks_percentage_two' => $item[106] ?? '',
                    'program_three' => $item[107] ?? '',
                    'passing_year_three' => $item[108] ?? '',
                    'marks_percentage_three' => $item[109] ?? '',
                    'program_four' => $item[110] ?? '',
                    'passing_year_four' => $item[111] ?? '',
                    'marks_percentage_four' => $item[112] ?? '',

                ];

                $employee_qualifications = EmployeeQualificationDetails::updateOrCreate(
                    ['employeemanagement_id'=> $employeeManagement->id],
                    $data_employee_qualifications
                );

                ##qualifications##


                $data_employee_workExperience = [
                    'employeemanagement_id' => $employeeManagement->id,
                    'jobtitle_one' => $item[113] ?? '',
                    'organization_one' => $item[114] ?? '',
                    'duration_one' => $item[115] ?? '',
                    'jobtitle_two' => $item[116] ?? '',
                    'organization_two' => $item[117] ?? '',
                    'duration_two' => $item[118] ?? '',
                    'jobtitle_three' => $item[119] ?? '',
                    'organization_three' => $item[120] ?? '',
                    'duration_three' => $item[121] ?? '',
                    'jobtitle_three' => $item[122] ?? '',
                    'organization_three' => $item[123] ?? '',
                    'duration_three' => $item[124] ?? '',

                ];


                $employee_experience = EmployeeWorkExperience::updateOrCreate(
                    ['employeemanagement_id'=> $employeeManagement->id],
                    $data_employee_workExperience
                );

              
              
            }
           
        

        }
    }
}
