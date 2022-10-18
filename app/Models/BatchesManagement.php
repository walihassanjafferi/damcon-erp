<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchesManagement extends Model
{
    use HasFactory;

    public function banks(){
        return $this->hasOne(Bankaccounts::class,'id','bank_id');
    }
}
