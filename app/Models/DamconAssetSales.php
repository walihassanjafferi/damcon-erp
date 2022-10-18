<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamconAssetSales extends Model
{
    use HasFactory;

    public function damconasset(){
        return $this->hasOne(Damcon_asssets::class,'id','asset_id');
    }
}
