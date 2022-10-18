<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPosManagement extends Model
{
    use HasFactory;
    public function supplier(){
        return $this->belongsTo(Suppliers::class,'supplier_id','id');
    }


    public function taxbody(){
        return $this->belongsTo(Taxation_bodies::class,'tax_body_id','id');
    }

    public function supplier_pos_items()
    {
        return $this->hasMany(SupplierPosManagementDetails::class,'supplier_pos_id','id');
    }
}
