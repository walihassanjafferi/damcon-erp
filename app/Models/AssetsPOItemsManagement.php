<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsPOItemsManagement extends Model
{
    use HasFactory;


    public function asset_items(){
        return $this->belongsTo(Damcon_asssets::class,'item','id');
    }
}
