<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsPurchaseOrdersManagement extends Model
{
    use HasFactory;

    
    public function asset_pos_items()
    {
        return $this->hasMany(AssetsPOItemsManagement::class,'assets_pos_id','id');
    }
}
