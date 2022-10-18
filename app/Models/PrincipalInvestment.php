<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrincipalInvestment extends Model
{
    use HasFactory;

    public function investor(){
        return $this->belongsTo(Investors::class,'investor_id','id');
    }

    public function bank(){
        return $this->belongsTo(Bankaccounts::class,'cash_deposit_bank_id','id');
    }
}
