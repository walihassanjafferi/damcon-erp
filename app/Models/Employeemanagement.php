<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Employeemanagement extends Model
{
    use HasFactory;

    protected $guarded = [];  


    public function project(){
        // return $this->hasOne(Project::class,'id','project_id');
        return $this->belongsTo(Project::class,'project_id','id');

    }

    public function subordinates12(){
       // return $this->belongsTo(Employeesubordinates::class,'employee_id','subordinate_id');
       // $this->hasMany(Comment::class, 'foreign_key', 'local_key');
    }
    
    public function salarybreakdown(){
        return $this->hasOne(employee_salarybreakdown::class,'employeemanagement_id','id');
    }

    public function preallowedleaves(){
        return $this->hasOne(Preallowed_leaves::class,'employeemanagement_id','id');
    }


    public function increments(){
        return $this->hasMany(IncrementManagement::class,'employeemanagement_id','id');
    }
    
    public function used_leaves(){
        return $this->hasMany(LeavesManagement::class,'employeemanagement_id','id');
    }

    public function advanceHRpayments(){
        return $this->hasMany(AdvanceHrPayment::class,'employeemanagement_id','id')->orderBy('id','desc');
  
    }

    public function getQHS(){
        return $this->hasMany(QualityHealthSafety::class,'employeemanagement_id','id')->orderBy('id','desc');

    }

    public function projectTransfers(){
        return $this->hasMany(InterProjectTransfer::class,'employeemanagement_id','id')->orderBy('id','desc');
    }

    public function lineManager(){
        return $this->belongsTo(Employeemanagement::class,'line_manager_employee_id','id');
    }

    public function subOrdinates(){
        return $this->hasMany(Employeesubordinates::class,'employee_id','id')->join('employeemanagements','employeesubordinates.subordinate_id','=','employeemanagements.id')->select('employeemanagements.employee_damcon_id','employeemanagements.name','employeemanagements.id');
    }

    public function employeeChallans(){
        return $this->hasMany(EmployeeTrafficChallan::class,'employeemanagement_id','id');
    }

    // public function getLeaverecord()
    // {
    //     return $this->hasMany(LeavesRecord::class,'employeemanagement_id','id')->select(DB::raw('sum(leaves_records.no_of_leave_days) as "leaves"'))->groupby('leaves_records.leave_type');
    // }
}
