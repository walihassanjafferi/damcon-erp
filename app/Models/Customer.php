<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name','address','street','state','city','country',
    'zip_code','cp1_name','cp1_phone_no','cp1_cell_no','cp1_email','cp1_fax',
    'cp2_name','cp2_phone_no','cp2_cell_no','cp2_email','cp2_fax','ntn_number',
    'strn_number','status'
    ];


    public function projects(){
       return $this->hasMany(Project::class, 'customer_id', 'id');
    }

    public function invoices(){
        return $this->hasMany(customer_invoice_management::class, 'customer_id', 'id');

    }
}   
