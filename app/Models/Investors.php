<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investors extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','type_of_invester','contact_no','status','date_of_creation'];

    public function ledgers()
    {
        return $this->hasMany(InvestorLedger::class,'investor_id','id');
    }

}
