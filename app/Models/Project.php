<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name','project_code','customer_id','project_description','customer_project_manager_name',
    'customer_project_manager_contact_no','damcon_project_manager_name','damcon_project_manager_contact_no',
    'project_start_date','project_end_date','status','project_region_box'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    ##To Customer Purchase Order Table
    public function toCustomerPOS(){
        return $this->hasMany(CustomerPosManagement::class,'project_id','id');
    }
}
