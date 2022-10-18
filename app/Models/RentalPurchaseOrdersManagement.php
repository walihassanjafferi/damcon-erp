<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalPurchaseOrdersManagement extends Model
{
    use HasFactory;

    public function  project(){
        return $this->hasOne(Project::class,'id','project_id');
    }

    public function  supplier(){
        return $this->hasOne(Suppliers::class,'id','supplier_id');
    }

    public function rental_pos_items()
    {
        return $this->hasMany(RentalPOItemsManagement::class,'rental_pos_id','id');
    }


}
