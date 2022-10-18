<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceHrPayment extends Model
{
    use HasFactory;

    public function hrCategories(){
        return $this->belongsTo(HrCategories::class,'category_id');
    }
}
