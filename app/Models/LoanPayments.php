<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPayments extends Model
{
    use HasFactory;

    public function banks(){
        return $this->hasOne(Bankaccounts::class,'id','bank_id');
    }

    public function project(){
        return $this->hasOne(Project::class,'id','project_id');
    }

    public function investor(){
        return $this->hasOne(Investors::class,'id','investor_id');
    }


}
