<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UninvoicedReceiveable extends Model
{
    use HasFactory;

    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
    public function taxBody()
    {
        return $this->belongsTo(Taxation_bodies::class,'tax_id','id');
    }
}
