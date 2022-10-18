<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalItemsManagement extends Model
{
    use HasFactory;

    public function supplier_rental(){
        return $this->belongsTo(Suppliers::class,'supplier_id','id');
    }

}
