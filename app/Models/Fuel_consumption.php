<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel_consumption extends Model
{
    use HasFactory;
    
    protected $fillable = ['title_po_number','project_id','date_of_entry','entry_person','driver_person',
    'fueling_item_id','fuel_item_code','supplier_id','consumption_month','quantity_in_liter','amount_with_sale_tax','rate_fuel_per_liter',
    'milage_hours','oil_filter_due_date','tax_body_id','taxation_month','tax_body_percentage','comments','images','sales_tax_withheld_at_source_per','supplier_withheld_tax_1_deduction_per','file_attachments','asset_type','item_type',
    'per_km_fuel_consumption','per_km_fuel_cost'];

    public function project(){
        return  $this->hasOne(Project::class,'id','project_id');
    }

    public function taxBody()
    {
        return $this->belongsTo(Taxation_bodies::class,'tax_body_id');
    }

    
    public function supplier(){
        return $this->hasOne(Suppliers::class,'id','supplier_id');
    }


    public function fuelItem(){
        return $this->hasOne(Fuel_items::class,'id','fuel_item_code');
    }

    public function assetItem(){
        return $this->hasOne(Damcon_asssets::class,'id','fueling_item_id');
    }


}
