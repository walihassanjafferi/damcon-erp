<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterProjectTransfer extends Model
{
    use HasFactory;

    public function previousProject(){
        return $this->belongsTo(Project::class,'current_project_id','id');
    }  
    
    public function newProject(){
        return $this->belongsTo(Project::class,'new_project_id','id');
    }  

}
