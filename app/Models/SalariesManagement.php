<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalariesManagement extends Model
{
    use HasFactory;

    public function projects(){
      
        return $this->belongsToMany(Project::class,'project_salaries');

    }
    public function bank(){
        return $this->hasOne(Bankaccounts::class,'id','debited_bank_id');
    }

    public function employee(){
        return $this->belongsto(Employeemanagement::class,'employeemanagement_id','id');
    }
}
