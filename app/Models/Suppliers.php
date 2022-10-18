<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;
    protected $fillable = ['name','suppliers_types_id','address','street','state','city','country',
    'zip_code','cp1_name','cp1_phone_no','cp1_cell_no','cp1_email','cp1_fax',
    'ntn_number','strn_number','bank_name','bank_account_title','bank_account_number','status','date_of_creation','balance'
    ];

    public function supplier_type(){
        return $this->hasOne(Suppliers_type::class, 'id', 'suppliers_types_id');
    }

    public function rental_supplier(){
        return $this->hasMany(RentalItemsManagement::class,'supplier_id','id');
    }
}
