<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncrementManagement extends Model
{
    use HasFactory;

    public function employee()
    {
        return $this->belongsTo(Employeemanagement::class,'employeemanagement_id','id');
    }
}
