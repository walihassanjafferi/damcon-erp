<?php
namespace App\Traits;

use App\Models\Project_items_inventory_updates;
use Auth;



trait ProjectItemsInventoryTraitUpdates {

   public static function inventoryUpdate($inventory_id,$date_of_update,$stock_update,$opening_stock,
   $opening_stock_cost,$quantity,$updated_stock,$updated_stock_cost,$avg_stock_unit_cost,$current_closing_stock,$current_closing_stock_cost)
   {
        $inventory_updates = new Project_items_inventory_updates();

        $inventory_updates->project_items_id = $inventory_id;

        $inventory_updates->date_of_update = $date_of_update;

        $inventory_updates->stock_update = $stock_update; //in/out

        $inventory_updates->opening_stock = $opening_stock;

        $inventory_updates->opening_stock_cost = $opening_stock_cost;

        $inventory_updates->quantity_type = $quantity;

        $inventory_updates->updated_stock = $updated_stock;

        $inventory_updates->updated_stock_cost = $updated_stock_cost;

        $inventory_updates->avg_stock_unit_cost = $avg_stock_unit_cost;

        $inventory_updates->current_closing_stock = $current_closing_stock;

        $inventory_updates->current_closing_stock_cost = $current_closing_stock_cost;
       
        $inventory_updates->save();

   }
   
}