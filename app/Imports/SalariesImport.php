<?php

namespace App\Imports;

use App\Models\Emp_import_salaries;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class SalariesImport implements ToModel , WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   

        if($row[0] != ''){
           
            $date = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]));
            
            $data = [
                'payment_id'=> isset($row[0]) ? $row[0] : ' ',

                'employee_code'=> isset($row[1]) ? $row[1] : ' ',

                'name'=> isset($row[2]) ? $row[2] : ' ',

                'salary_status'=> isset($row[3]) ? $row[3] : 0,

                'joining_date'=> isset($row[4]) ? $date : '20-10-2022 ',

                'cnic'=> isset($row[5]) ? $row[5] : ' ',

                'salary_account_type'=> isset($row[6]) ? $row[6] : ' ',

                'salaray_receiving_emp_name'=> isset($row[7]) ? $row[7] : ' ',

                'salaray_receiving_emp_id'=> isset($row[8]) ? $row[8] : ' ',

                'salaray_receiving_emp_bank_id'=> isset($row[9]) ? $row[9] : ' ',

                'self_bank_account_details'=> isset($row[10]) ? $row[10] : ' ',

                'emp_email'=> isset($row[14]) ? $row[11] : ' ',

                'send_salary_slip_check'=> isset($row[12]) ? $row[12] : 0,

                'desgination'=> isset($row[13]) ? $row[13] : ' ',

                'project_id'=> isset($row[14]) ? $row[14] : ' ',
                
                'project'=> isset($row[15]) ? $row[15] : ' ',

                'region'=> isset($row[16]) ? $row[16] : ' ',

                'location'=> isset($row[17]) ? $row[17] : ' ',

                'income_tax'=> isset($row[18]) ? $row[18] : ' ',

                'final_adjustments'=> isset($row[19]) ? $row[19] : ' ',

                'final_comments'=> isset($row[20]) ? $row[20] : ' ',

                'basic_salary'=> isset($row[21]) ? floatval($row[21]) : 0,

                'medical_allowance'=> isset($row[22]) ? floatval($row[22]) : 0,

                'mobile_allowance'=> isset($row[23]) ? floatval($row[23]) : 0,

                'laptop_bonus'=> isset($row[24]) ? floatval($row[24]) : 0,

                'conveyance_Allowance'=> isset($row[25]) ? floatval($row[25]) : 0,

                'other_allowance'=> isset($row[26]) ? floatval($row[26]) : 0,

                'over_time'=> isset($row[27]) ? $row[27] : ' ',

                'over_time_comments'=> isset($row[28]) ? $row[28] : ' ',

                'kpi_other_bonus'=> isset($row[29]) ? $row[29] : ' ',

                'kpi_other_bonus_comments'=> isset($row[30]) ? $row[30] : ' ',

                'eda_allowance'=> isset($row[31]) ? $row[31] : ' ',

                'eda_allowance_comments'=> isset($row[32]) ? $row[32] : ' ',

                'tada_allowance'=> isset($row[33]) ? $row[33] : ' ',

                'tada_allowance_comments'=> isset($row[34]) ? $row[34] : ' ',

                'advanced_salary_id'=> isset($row[35]) ? $row[35] : ' ',

                'advanced_salary'=> isset($row[36]) ? $row[36] : ' ',

                'advanced_salary_comments'=> isset($row[37]) ? $row[37] : ' ',

                'final_settlement_termination'=> isset($row[38]) ? $row[38] : ' ',

                'final_settlement_termination_comments'=> isset($row[39]) ? $row[39] : ' ',

                'miscellaneous_payment'=> isset($row[40]) ? $row[40] : ' ',

                'miscellaneous_payment_comments'=> isset($row[41]) ? $row[41] : ' ',

                'gross_payment'=> isset($row[42]) ? $row[42] : ' ',

                'health_life_insurance_deduction'=> isset($row[43]) ? $row[43] : ' ',

                'eobi_deduction'=> isset($row[44]) ? $row[44] : ' ',

                'absent_deduction'=> isset($row[45]) ? $row[45] : ' ',

                'absent_deduction_comments'=> isset($row[46]) ? $row[46] : ' ',

                'advanced_salary_deduction'=> isset($row[47]) ? $row[47] : ' ',

                'advanced_salary_deduction_comments'=> isset($row[48]) ? $row[48] : ' ',

                'kpi_deduction'=> isset($row[49]) ? $row[49] : ' ',

                'kpi_deduction_comments'=> isset($row[50]) ? $row[50] : ' ',

                'late_coming_deduction_comments' => isset($row[51]) ? $row[51] : ' ',

                'late_coming_deduction'=> isset($row[52]) ? $row[52] : ' ',

                'miscellaneous_deduction'=> isset($row[53]) ? $row[53] : ' ',

                'miscellaneous_deduction_comments'=> isset($row[54]) ? $row[54] : ' ',

                'total_deduction'=> isset($row[55]) ? $row[55] : ' ',
            ];
            // return  Emp_import_salaries::create(
            //    // ['payment_id' =>  $row[0]],
            //     $data
            // );

            return  Emp_import_salaries::updateOrCreate(
                ['payment_id' => $row[0],'cnic' =>  $row[5]],
                $data
            );
       
        }
            
    }

    public function startRow(): int
    {
        return 2;
    }
}
