<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeavesManagement extends Model
{
    use HasFactory;

    public function leavesrecord() {
       
        return $this->hasMany(LeavesRecord::class,'leaves_management_id','id');
    }
}
