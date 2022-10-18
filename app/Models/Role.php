<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Exception;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];
    // public function permissions() {

    //     return $this->belongsToMany(Permission::class,'roles_permissions');
            
    //  }
     
     public function users() {
        return $this->hasMany(User::class);
            
     }
}
