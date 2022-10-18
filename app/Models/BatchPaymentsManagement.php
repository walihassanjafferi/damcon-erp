<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchPaymentsManagement extends Model
{
    use HasFactory;

    public function banks(){
        return $this->hasOne(Bankaccounts::class,'id','bank_of_batch');
    }

    public function batches(){
        return $this->hasOne(BatchesManagement::class,'id','batch_id');
    }
}
