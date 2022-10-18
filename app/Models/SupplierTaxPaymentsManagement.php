<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierTaxPaymentsManagement extends Model
{
    use HasFactory;

    public function suppliers(){
        return $this->belongsTo(Suppliers::class,'supplier_id','id');
    }

    public function bank(){
        return $this->belongsTo(Bankaccounts::class,'cash_deposit_bank_id','id');
    }
}
