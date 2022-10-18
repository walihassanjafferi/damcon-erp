<?php

namespace App\Http\Controllers\User\inventorymanagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Suppliers;
use App\Models\categories;
use App\Models\chidcategories;
use App\Models\Project_items_inventory;
use App\Traits\ProjectItemsInventoryTraitUpdates as Inventory_update;
use App\Models\Project_items_inventory_updates;
Use \Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use App\Models\ImprovedCategories;
use Auth;
use Session;
use Exception;
use DB;


class ProjectItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('manage-project-item-inventory'))
        {
            try{
                $items_inventory = Project_items_inventory::orderBy('id','Desc')->get();

                // $items_inventory = Project_items_inventory::join('project_items_inventory_updates','project_items_inventory_updates.project_items_id','project_items_inventories.id')
                // ->select(DB::raw("SUM(project_items_inventory_updates.stock_update) as count WHERE project_items_inventory_updates.stock_update='stock in'") )->get();


                // $subQuery = DB::query()->from('project_items_inventory_updates')->where('project_items_inventory_updates.stock_update', 'stock in');
                // // dd($subQuery);
                // $query = DB::query()->fromSub($subQuery, 'subquery');
                // $query->join('project_items_inventories', function(JoinClause $join) {
                //     $join->on('subquery.project_items_id', 'project_items_inventories.id');
                // })->select('query.stock_update');

                // dd($query);

                if($items_inventory)
                {
                    return view('user.inventorymanagement.projectitemsinventory.index',compact('items_inventory'));
                }
                else{
                    Session::flash('warning','No Inventory Items found');
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
        if(Auth::user()->can('manage-project-item-inventory'))
        {
            $suppliers = Suppliers::where('status',1)->where('suppliers_types_id','1')->pluck('name','id')->toArray();
            $projects = Project::where('status',1)->pluck('name','id')->toArray();
           // $categories = categories::where('status',1)->where('module_id',9)->pluck('name','id')->toArray();
            $module_name = "project_item"; 
            $categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNull('main_id')->whereNull('sub_id')->select('id','category_name')->get();

             return view('user.inventorymanagement.projectitemsinventory.create',compact('suppliers','projects','categories'));
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
            //'technical_specification_1'=>'required|max:1000',  
            //'technical_specification_2'=>'required|max:1000', 
            'item_code'=>'required|unique:project_items_inventories,item_code', 
        ]);
        

        if(Auth::user()->can('manage-project-item-inventory'))
        {
            DB::beginTransaction();

            $current_cost_format = (int)str_replace(',', '', $request->current_stock_cost);

            $input['item_code'] = $request->item_code;
            $input['item_name'] = $request->item_name;
            // $input['category_id'] = $request->category_id;
            // $input['chidcategories_id'] = $request->child_category_id;
            $input['current_balance_item'] = $request->current_balance_item;
            $input['current_stock_cost'] = $current_cost_format;
            $input['item_brand'] = $request->item_brand;
            $input['unit_of_measure'] = $request->unit_of_measure;
            $input['date_of_addition'] = $request->date_of_addition;
            $input['description'] = $request->description;
            $input['technical_specification_1'] = $request->technical_specification_1;
            $input['technical_specifications_2'] = $request->technical_specification_2;
            $input['comments'] = $request->comments;
            $input['cat_parent_id'] = $request->cat_parent_id;
            $input['cat_main_id'] = $request->cat_main_id;
            $input['cat_sub_id'] = $request->cat_sub_id;
            $input['cat_sub_sub_id'] = $request->cat_sub_sub_id;

            $projects = $request->projects;
            $suppliers = $request->suppliers;

            //calculating cost_per_unit

            if(intval($current_cost_format) > 0 && intval($request->current_balance_item) > 0)
            {
                $cost_per_unit = (intval($current_cost_format) / intval($request->current_balance_item));
            }
            else{
                $cost_per_unit = 0;
            }

            $input['cost_per_unit'] = $cost_per_unit;

            $input['average_unit_cost'] = $cost_per_unit;


            //calculating cost_per_unit
           
            try {

                // $check_item_Code = Project_items_inventory::where('item_code',$request->item_code)->count();

                // if($check_item_Code >= 1)
                // {
                //     Session::flash('warning','Duplicate Item Code');
                //     return redirect()->back()->withInput();
                // }

                $project_item = Project_items_inventory::create($input);
               
                if($project_item->wasRecentlyCreated)
                {

                    $project_item->suppliers()->sync($suppliers);
                    $project_item->projects()->sync($projects);

                    Inventory_update::inventoryUpdate(
                        $project_item->id, //project id
                        Carbon::now(), //update date
                        "stock in", //stock udpate
                        $project_item->current_balance_item, //opening stock
                        $current_cost_format,  //opening stock cost
                        $project_item->current_balance_item,
                        $project_item->current_balance_item,
                        $current_cost_format,
                        $cost_per_unit,
                        $project_item->current_balance_item,
                        $current_cost_format,
                    );

                    DB::commit();
                    Session::flash('created', 'Project Inventory Item Added successfully!');
                    return redirect()->route('projectitems.index');
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
      
        if(Auth::user()->can('manage-project-item-inventory'))
        {
            $id = decrypt($id);
            $project_inventory = Project_items_inventory::find($id);
            $inventory_updates = Project_items_inventory_updates::where('project_items_id',$id)->get();
            $inventoryStockIn  = Project_items_inventory_updates::where([['stock_update', 'stock in'], ['project_items_id',$id]])->sum('updated_stock');
            $inventoryStockOut = Project_items_inventory_updates::where([['stock_update', 'stock out'], ['project_items_id',$id]])->sum('updated_stock');
            $inventoryStockCostIn  = Project_items_inventory_updates::where([['stock_update', 'stock in'], ['project_items_id',$id]])->sum('updated_stock_cost');
            $inventoryStockCostOut  = Project_items_inventory_updates::where([['stock_update', 'stock out'], ['project_items_id',$id]])->sum('updated_stock_cost');

            $stock_cost = $inventoryStockCostIn - $inventoryStockCostOut;

            return view('user.inventorymanagement.projectitemsinventory.view',compact('project_inventory','inventory_updates','inventoryStockIn','inventoryStockOut','stock_cost'));
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
        if(Auth::user()->can('manage-project-item-inventory'))
        {
            
            $id = decrypt($id);
            $project_item = Project_items_inventory::find($id);
            // $category_id =  $project_item->category_id;
            // $category = categories::find($category_id);
            // $child_category = $category->childCatgories->pluck('name','id')->toArray();
            $module_name = "project_item";
            $parent_categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNull('main_id')->whereNull('sub_id')->select('id','category_name')->get();
            $main_categories = ImprovedCategories::where('module_name',$module_name)->whereNotNull('parent_id')->whereNull('main_id')->whereNull('sub_id')->select('id','category_name')->get();
            $sub_categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNotNull('main_id')->whereNull('sub_id')->select('id','category_name')->get();
            $sub_sub_categories = ImprovedCategories::where('module_name',$module_name)->whereNull('parent_id')->whereNull('main_id')->whereNotNull('sub_id')->select('id','category_name')->get();


            $selected_projects = $project_item->projects->pluck('id')->toArray();
            $selected_suppliers =  $project_item->suppliers->pluck('id')->toArray();
            $suppliers = Suppliers::where('status',1)->where('suppliers_types_id','1')->pluck('name','id')->toArray();
            $projects = Project::where('status',1)->pluck('name','id')->toArray();
            $categories = categories::where('status',1)->where('module_id',9)->pluck('name','id')->toArray();
           
             return view('user.inventorymanagement.projectitemsinventory.edit',compact('project_item','suppliers','projects','selected_projects','selected_suppliers'
            ,'parent_categories','main_categories','sub_categories','sub_sub_categories'));
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
        if(Auth::user()->can('manage-project-item-inventory'))
        {
            $validated = $request->validate([
                // 'technical_specification_1'=>'required|max:2000',  
                // 'technical_specification_2'=>'required|max:2000', 
                'item_code'=>'required'
            ]);
           
            try{
                $id = decrypt($id);

                $project_item = Project_items_inventory::find($id);
              
                if($project_item)
                {
                    $input['item_code'] = $request->item_code;
                    $input['item_name'] = $request->item_name;
                    // $input['category_id'] = $request->category_id;
                    // $input['child_category_id'] = $request->child_category_id;
                    $input['current_balance_item'] = $request->current_balance_item;
                    $input['current_stock_cost'] = $request->current_stock_cost;
                    $input['item_brand'] = $request->item_brand;
                    $input['unit_of_measure'] = $request->unit_of_measure;
                    $input['date_of_addition'] = $request->date_of_addition;
                    $input['description'] = $request->description;
                    $input['technical_specification_1'] = $request->technical_specification_1;
                    $input['technical_specification_2'] = $request->technical_specification_2;
                    $input['comments'] = $request->comments;
                    $input['cat_parent_id'] = $request->cat_parent_id;
                    $input['cat_main_id'] = $request->cat_main_id;
                    $input['cat_sub_id'] = $request->cat_sub_id;
                    $input['cat_sub_sub_id'] = $request->cat_sub_sub_id;
                    $projects = $request->projects;
                    $suppliers = $request->suppliers;


                    $project_item->update($input);
                
                    $project_item->suppliers()->detach();
                    $project_item->projects()->detach();
                
                
                    $project_item->suppliers()->sync($suppliers);
                    $project_item->projects()->sync($projects);
    
                    Session::flash('updated', 'Project Inventory Item updated successfully!');
                    return redirect()->route('projectitems.index');
            
                }
                else 
                {
                    Session::flash('error','Project items Inventory not found!');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $id = $request->id;
        if(Auth::user()->can('manage-project-item-inventory'))
        {
           try {    
                $project_items_inventory = Project_items_inventory::find($id);
            
                if($project_items_inventory)
                {
                     $project_items_inventory->delete();
                    return response()->json(['success' => true, 'message' => 'Project item inventory deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Project item inventory deletion failed'], 422);
                }
               
           }
           catch(Exception $e){
                Session::flash('error', 'Project item inventory not Deleted');
                return redirect()->back();
           }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    public function getchildCategories(Request $request){
        $category_id =  $request->category_id;
        $categories = categories::find($category_id);
        return response()->json(['success' => true, 'categories' => $categories->childCatgories->toArray()], 200);
     
    }


    public function getajaxcategoryByID(Request $request){

        $category_id = $request->category_id;
        $category_select = $request->category_select;
        $module_name = $request->module_name;

        if($category_select == 'parent')
        {   
            $categories = ImprovedCategories::where('module_name',$module_name)->where('parent_id',$category_id)->select('id','category_name')->get();
        }
        if($category_select == 'main')
        {
            $categories = ImprovedCategories::where('module_name',$module_name)->where('main_id',$category_id)->select('id','category_name')->get();
        }
        if($category_select == 'sub')
        {
            $categories = ImprovedCategories::where('module_name',$module_name)->where('sub_id',$category_id)->select('id','category_name')->get();
        }
        

        return response()->json(['success' => true, 'categories' => $categories], 200);


    }
}
