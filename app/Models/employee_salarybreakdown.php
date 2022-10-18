<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_salarybreakdown extends Model
{
    use HasFactory;
    
    protected $guarded = [];  

    protected $table = 'employee_salarybreakdowns';

    protected $fillable = ['employeemanagement_id','basic_salary','medical_allowance','mobile_allowance','laptop_bonus','conveyance_allowance','other_allowance'];
}
