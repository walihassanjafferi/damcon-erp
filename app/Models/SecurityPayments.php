<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityPayments extends Model
{
    use HasFactory;

    public function banks(){
        return $this->hasOne(Bankaccounts::class,'id','bank_id');
    }

    public function project(){
        return $this->hasOne(Project::class,'id','project_id');
    }

    public function paymenttype(){
        return $this->hasOne(categories::class,'id','payment_type');
    }

    public function customer_rel(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
