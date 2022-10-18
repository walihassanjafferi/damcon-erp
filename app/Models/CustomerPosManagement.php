<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPosManagement extends Model
{
    use HasFactory;


    ##To Project Table
    public function toProject(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
}
