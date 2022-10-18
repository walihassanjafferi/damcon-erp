<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    
    protected $fillable = ['name','slug','module_id'];
    
    // public function roles() {

    //     return $this->belongsToMany(Role::class,'roles_permissions');
            
    //  }
     
     public function users() {
        return $this->belongsToMany(User::class,'users_permissions');    
     }

     public function module(){
      return $this->hasOne(Configuration::class, 'id', 'module_id');
      }
}
