<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salestaxreturnmanagement extends Model
{
    use HasFactory;

    public function taxBody(){
        return $this->belongsTo(Taxation_bodies::class,'tax_id','id');
    }

    public function bank(){
        return $this->belongsTo(Bankaccounts::class,'cash_deposit_bank_id','id');
    }
}
