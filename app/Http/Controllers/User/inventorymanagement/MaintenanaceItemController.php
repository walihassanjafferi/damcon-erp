<?php

namespace App\Http\Controllers\User\inventorymanagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Suppliers;
use App\Models\categories;
use App\Models\chidcategories;
use App\Models\Mainterance_items_inventory;
use App\Models\maintenance_items_inventory_updates;
use App\Traits\MaintenancetemsInventoryTraitUpdates as MaintenanaceInventoryupdate;
use Carbon\Carbon;
use App\Models\ImprovedCategories;
use Auth;
use Session;
use Exception;
use DB;

class MaintenanaceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('manage-maintenance-item-inventory'))
        {
            try{
                $maintenanace_items = Mainterance_items_inventory::orderBy('id','Desc')->get();
                if($maintenanace_items)
                {
                    return view('user.inventorymanagement.maintenanceitemsinventory.index',compact('maintenanace_items'));
                }
                else{
                    Session::flash('warning','No Items found');
                    return redirect()->back();
                }
            }
            catch(Exception $e)
            {
                Session::flash('error',$e->getMessage());
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('manage-maintenance-item-inventory'))
        {
            // $categories = categories::where('status',1)->where('module_id',9)->pluck('name','id')->toArray();
            $suppliers = Suppliers::where('status',1)->where('suppliers_types_id','5')->pluck('name','id')->toArray();
            $module_name = "maintenance_item"; 
            $categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNull('main_id')->whereNull('sub_id')->select('id','category_name')->get();
            return view('user.inventorymanagement.maintenanceitemsinventory.create',compact('categories','suppliers'));
        
        
        }
        else{
            return redirect()->route('not_authorized');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
     
        $validated = $request->validate([
            // 'technical_specification_1'=>'required|max:1000',  
            // 'technical_specification_2'=>'required|max:1000', 
            'item_code'=>'required|unique:mainterance_items_inventories,item_code',
        ]);

        if(Auth::user()->can('manage-maintenance-item-inventory'))
        {
            DB::beginTransaction();

            $current_stock_cost_format = (int)str_replace(',', '', $request->current_stock_cost);

            $input['item_code'] = $request->item_code;
            $input['item_name'] = $request->item_name;
            $input['service_id'] = $request->service_id;
            // $input['category_id'] = $request->category_id;
            // $input['chidcategories_id'] = $request->child_category_id;
            $input['current_balance_item'] = $request->current_balance_item;
            $input['current_stock_cost'] = $current_stock_cost_format;
            $input['item_brand'] = $request->item_brand;
            $input['unit_of_measure'] = $request->unit_of_measure;
            $input['date_of_addition'] = $request->date_of_addition;
            $input['description'] = $request->description;
            $input['technical_specification_1'] = $request->technical_specification_1;
            $input['technical_specifications_2'] = $request->technical_specification_2;
            $input['comments'] = $request->comments;
            $input['item_type'] = $request->item_type;
            $input['supplier_id'] = $request->supplier_id;
            $input['cat_parent_id'] = $request->cat_parent_id;
            $input['cat_main_id'] = $request->cat_main_id;
            $input['cat_sub_id'] = $request->cat_sub_id;
            $input['cat_sub_sub_id'] = $request->cat_sub_sub_id;

            // $projects = $request->projects;
            // $suppliers = $request->suppliers;

            //calculating cost_per_unit
            if(intval($current_stock_cost_format) > 0 && intval($request->current_balance_item) > 0)
            {
                $cost_per_unit = (intval($current_stock_cost_format) / intval($request->current_balance_item));
            }
            else{
                $cost_per_unit = 0;
            }

            $input['cost_per_unit'] = $cost_per_unit;

            

            //calculating cost_per_unit
           
            try {

                // $check_item_Code = Mainterance_items_inventory::where('item_code',$request->item_code)->count();

                // if($check_item_Code >= 1)
                // {
                //     Session::flash('warning','Duplicate Item Code');
                //     return redirect()->back()->withInput();
                // }

                $maintenanace_item = Mainterance_items_inventory::create($input);
               
                if($maintenanace_item->wasRecentlyCreated)
                {

                    // now updating maintenance inventory

                    MaintenanaceInventoryupdate::maintenanceinventoryUpdate(
                        $maintenanace_item->id, //maintenance id
                        Carbon::now(), //update date
                        "stock in", //stock udpate
                        $maintenanace_item->current_balance_item, //opening stock
                        $maintenanace_item->current_stock_cost,  //opening stock cost
                        $maintenanace_item->current_balance_item,
                        $maintenanace_item->current_balance_item,
                        $maintenanace_item->current_stock_cost,
                        $cost_per_unit,
                        $maintenanace_item->current_balance_item,
                        $maintenanace_item->current_stock_cost,
                    );
                    

                    //now updating inventory 
                    DB::commit();
                    Session::flash('created', 'Maintenanace Item Added successfully!');
                    return redirect()->route('maintenanaceiteminventory.index');
                }

            }
            catch(Exception $e){

                DB::rollback();
                Session::flash('error',$e->getMessage());
                return redirect()->back()->withInput();
            }
            
        }
        else{
            return redirect()->route('not_authorized');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can('manage-maintenance-item-inventory'))
        {
            $id = decrypt($id);
            $maintenance_inventory = Mainterance_items_inventory::find($id);
            $inventory_updates = maintenance_items_inventory_updates::where('maintenance_item_id',$id)->get();

            return view('user.inventorymanagement.maintenanceitemsinventory.view',compact('maintenance_inventory','inventory_updates'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('manage-maintenance-item-inventory'))
        {
            $id = decrypt($id);
            $maintenanace_item = Mainterance_items_inventory::find($id);
            $suppliers = Suppliers::where('status',1)->where('suppliers_types_id','5')->pluck('name','id')->toArray();
            // $categories = categories::where('status',1)->where('module_id',9)->pluck('name','id')->toArray();
            
            $module_name = "maintenance_item";
            $parent_categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNull('main_id')->whereNull('sub_id')->select('id','category_name')->get();
            $main_categories = ImprovedCategories::where('module_name',$module_name)->whereNotNull('parent_id')->whereNull('main_id')->whereNull('sub_id')->select('id','category_name')->get();
            $sub_categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNotNull('main_id')->whereNull('sub_id')->select('id','category_name')->get();
            $sub_sub_categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNull('main_id')->whereNotNull('sub_id')->select('id','category_name')->get();

            
            return view('user.inventorymanagement.maintenanceitemsinventory.edit',compact('maintenanace_item','suppliers','parent_categories','main_categories','sub_categories','sub_sub_categories'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            // 'technical_specification_1'=>'required|max:1000',  
            // 'technical_specification_2'=>'required|max:1000', 
            'item_code_edit'=>'required|max:20',
        ]);


        if(Auth::user()->can('manage-maintenance-item-inventory'))
        {
            DB::beginTransaction();

            try{
               
                $id = decrypt($id);

                $maintenance_item = Mainterance_items_inventory::find($id);

                if($maintenance_item)
                {
                    $input['item_code'] = $request->item_code_edit;
                    $input['item_name'] = $request->item_name;
                    $input['service_id'] = $request->service_id;
                    $input['category_id'] = $request->category_id;
                    $input['chidcategories_id'] = $request->child_category_id;
                    $input['current_balance_item'] = $request->current_balance_item;
                    $input['current_stock_cost'] = $request->current_stock_cost;
                    $input['item_brand'] = $request->item_brand;
                    $input['unit_of_measure'] = $request->unit_of_measure;
                    $input['date_of_addition'] = $request->date_of_addition;
                    $input['description'] = $request->description;
                    $input['technical_specification_1'] = $request->technical_specification_1;
                    $input['technical_specifications_2'] = $request->technical_specification_2;
                    $input['comments'] = $request->comments;
                    $input['supplier_id'] = $request->supplier_id;

                    // $projects = $request->projects;
                    // $suppliers = $request->suppliers;


                    $maintenance_item->update($input);

                    DB::commit();

                
                    Session::flash('updated', 'Maintenance Item Inventory updated successfully!');
                    return redirect()->route('maintenanaceiteminventory.index');
            
                }
                else 
                {
                    Session::flash('error','Maintenanace items Inventory not found!');
                    return redirect()->back();
                }


            }
            catch(Exception $e)
            {
               
                DB::rollback();
                Session::flash('error',$e->getMessage());
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $id = $request->id;
        if(Auth::user()->can('manage-maintenance-item-inventory'))
        {
           try {    
                $maintenance_items_inventory = Mainterance_items_inventory::find($id);
            
                if($maintenance_items_inventory)
                {
                     $maintenance_items_inventory->delete();
                    return response()->json(['success' => true, 'message' => 'Maintenance item inventory deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Maintenance item inventory deletion failed'], 422);
                }
           }
           catch(Exception $e){
                Session::flash('error', 'Maintenance item inventory not Deleted');
                return redirect()->back();
           }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }
    
}
