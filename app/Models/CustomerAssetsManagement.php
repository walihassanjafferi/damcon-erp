<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAssetsManagement extends Model
{
    use HasFactory;

    /**
     * @var mixed
     */
    private $customer_id;

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function project(){
        return $this->hasOne(Project::class,'id','project_id');
    }

    public function employee(){
        return $this->belongsTo(Employeemanagement::class,'asset_incharge_id','id');
    }
}
