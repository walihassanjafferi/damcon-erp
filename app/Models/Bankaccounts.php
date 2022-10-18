<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bankaccounts extends Model
{
    use HasFactory;
    protected $fillable = ['name','title','account_number','overdraft_facility','overdraft_limit',
    'avaliable_funds','overdraft_used','current_balance','opening_date'];

    public function sender(){
        return $this->hasMany(inter_bank_transfer::class,'sender_bank_id','id');
    }

    public function receiver(){
        return $this->hasMany(inter_bank_transfer::class,'receiver_bank_id','id');
    }
    
    public function transactions(){
        return $this->hasMany(BankTransactions::class,'bank_id','id')->orderBy('bank_transactions.id','desc');
    }
   
}
