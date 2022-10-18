<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPayments extends Model
{
    use HasFactory;


    public function category()
    {
        return $this->belongsTo(ErpCategories::class,'category_id', 'id');
    }

    public function main_category()
    {
        return $this->belongsTo(ErpCategories::class, 'main_category_id', 'id');

    }
    public function subCategory()
    {
        return $this->belongsTo(ErpCategories::class, 'sub_category_id', 'id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(Bankaccounts::class, 'bank_id', 'id');

    }

    
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');

    }
}
