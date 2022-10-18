<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankPayments extends Model
{
    use HasFactory;

    public function projects(){
        return $this->hasOne(Project::class,'id','project_id');
    }

    public function batches(){
        return $this->hasOne(BatchPaymentsManagement::class,'id','batch_id');
    }

    public function banks(){
        return $this->hasOne(Bankaccounts::class,'id','bank_id');
    }

    
}
