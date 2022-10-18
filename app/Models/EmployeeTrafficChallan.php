<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTrafficChallan extends Model
{
    use HasFactory;

    
    public function employee(){
        return $this->belongsto(Employeemanagement::class,'employeemanagement_id','id');
    }
}
