<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPayments extends Model
{
    use HasFactory;

    public function supplierpo()
    {
        return $this->hasOne(SupplierPosManagement::class,'id','po_id');
    }

    public function banks()
    {
        return $this->hasOne(Bankaccounts::class,'id','bank_id');
    }
    public function supplier_type_name(){

        return $this->hasOne(Suppliers_type::class,'id','suppliers_types_id');
    }

    public function supplierName()
    {
        return $this->hasOne(Suppliers::class,'id','supplier_id');
    }


}
