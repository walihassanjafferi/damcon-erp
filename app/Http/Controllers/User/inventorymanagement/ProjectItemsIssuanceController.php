<?php

namespace App\Http\Controllers\User\inventorymanagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Project_items_issuance;
use App\Models\Project_inventory_items;
use App\Models\Employeemanagement;
##main model
use App\Models\Project_items_inventory;
use App\Models\Project_items_inventory_updates;
##main model
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use DB;
use Auth;
use Session;
use Exception;
use File;
use App\Traits\ProjectItemsInventoryTraitUpdates as Inventory_update;
Use \Carbon\Carbon;


class ProjectItemsIssuanceController extends Controller
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
                $items_issuance = Project_items_issuance::orderBy('id','Desc')->with('items')->get();
                if($items_issuance)
                {
                    return view('user.inventorymanagement.projectitemsissuance.index',compact('items_issuance'));
                }
                else{
                    Session::flash('warning','No Items found');
                    return redirect()->back();
                }
            }
            catch(Exception $e)
            {
                Session::flash('error','Error Occured');
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
 
            $projects = Project::where('status',1)->pluck('name','id')->toArray();
        

             return view('user.inventorymanagement.projectitemsissuance.create',compact('projects'));
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
        if(Auth::user()->can('manage-project-item-inventory'))
        {
            DB::beginTransaction();
            try {

                $image_names = array();
                $items_name = array();
                $items_quantity = array();
                $items_cost = array();

                ##Checking if items are avaliable

                $items_name = $request->item_name;
                $items_quantity = $request->item_quantity;
                $item_cost = $request->item_cost;
                
                $insifficient = false; $insifficient_items = array(); $insufficient_qty = array();
                foreach($items_name as $index=>$item)
                {  
                
                    $input_items['item_name'] = $item;
                    $input_items['item_qunatity'] = $items_quantity[$index];
                 
                   // $items_update = Project_items_inventory_updates::where('project_items_id',$item)->where('stock_update','stock in')->orderBy('id','desc')->first();
                  
                    $stockInQty  = Project_items_inventory_updates::where([['project_items_id', $item], ['stock_update','stock in']])->sum('updated_stock');
                    $stockOutQty = Project_items_inventory_updates::where([['project_items_id', $item], ['stock_update','stock out']])->sum('updated_stock');
                    
                
            
                    $item_inventory = Project_items_inventory::find($item);

                    $stockQty =  $stockInQty - $stockOutQty;

                    if($item)
                    {
                        if($input_items['item_qunatity']<= $stockQty)
                        {
                            continue;
                        }
                        else{
                          
                            $insifficient = true;
                            $item = " ".$item_inventory->item_name." ";
                            $qty = "avalible QTY is ".$stockQty.' ';
                            array_push($insifficient_items,$item);
                            array_push($insufficient_qty,$qty);

                    
                        }
                    }
                }

                if($insifficient)
                {
                   // dd('warning',implode(',',$insifficient_items),implode(',',$insufficient_qty).'has Insufficient quantity!');
                    Session::flash('warning',implode(',',$insifficient_items).' '.implode(',',$insufficient_qty).' has Insufficient quantity!');
                    return redirect()->back()->withInput();
                }
                ##checking items avaliable
                
             
                ##saving images
                 if($request->hasfile('images'))
                 {   
                     foreach($request->file('images') as $image)
                     { 

                        if($image->getClientOriginalExtension() == 'pdf')
                        {
                            $fileName = rand(10,5000).time() . '.' . $image->getClientOriginalExtension();
                            $store = Storage::disk('local')->put('public/items_issuance/PDF'.'/'.$fileName,file_get_contents($image),'public');
                        }
                        else
                        {
                           // $image = $image;
                            $fileName = rand(10,5000).time() . '.' . $image->getClientOriginalExtension();
                
                            $img = Image::make($image->getRealPath());
                            $img->resize(300, 300, function ($constraint) {
                                $constraint->aspectRatio();                 
                            });
                
                            $img->stream();
                            Storage::disk('local')->put('public/items_issuance'.'/'.$fileName, $img, 'public');
                        }

                         array_push($image_names,$fileName);
                         $fileName = '';
                    }   
                    
                   
                    $input['file_attachments'] = json_encode($image_names);
                 }
                 
                //
                        
                ##saving imagesend


                ##saving item issuance
                 
                $input['date_of_issuance'] = $request->date_of_issuance;
                $input['title'] = $request->title;
                $input['project_id'] = $request->project_id;
                $input['region'] = $request->region;
                $input['issued_person_id'] = $request->issued_person_id;
                $input['comments'] = $request->comments;
                $input['issued_items_cost'] = 0;
                
              
                $item_issuance = Project_items_issuance::firstOrCreate($input);
                // if($item_issuance->wasRecentlyCreated)
                // {
                    $item_issuance->refresh();

                    ##subtracting item issuance in inventory update

                    foreach($items_name as $index=>$item)
                    {  
                        $input_items['item_name'] = $item;
                        $input_items['item_qunatity'] = $items_quantity[$index];
                        $input_items['item_cost'] =  $items_quantity[$index] * $item_cost[$index];

                        // $item = Project_items_inventory::find($item);
                        // $item->current_balance_item = $item->current_balance_item - $items_quantity[$index];
                        // $item->save();

                        // find inventory update
                        
                        $item_inventory_update = Project_items_inventory::find($item);
                       
                        // $update_inventory = new Project_items_inventory_updates();
                        // $update_inventory->project_items_id = $item;
                        // $update_inventory->date_of_update = Carbon::now();
                        // $update_inventory->stock_update = 'stock out';
                        // $update_inventory->opening_stock = $item_inventory_update->opening_stock;
                        // $update_inventory->opening_stock_cost = $item_inventory_update->opening_stock_cost;
                        // $update_inventory->updated_stock =  $input_items['item_qunatity'];
                        // $update_inventory->updated_stock_cost = $items_quantity[$index] * $item_cost[$index];
                        // $update_inventory->avg_stock_unit_cost;

                        $stockInQty  = Project_items_inventory_updates::where([['project_items_id', $item], ['stock_update','stock in']])->sum('updated_stock');
                        $stockOutQty = Project_items_inventory_updates::where([['project_items_id', $item], ['stock_update','stock out']])->sum('updated_stock');
                        
                        $stockInCost  = Project_items_inventory_updates::where([['project_items_id', $item], ['stock_update','stock in']])->sum('updated_stock_cost');
                        $stockOutCost = Project_items_inventory_updates::where([['project_items_id', $item], ['stock_update','stock out']])->sum('updated_stock_cost');
    
    
                        $stockQty =  $stockInQty - $stockOutQty;
    
                        $stockCost = $stockInCost - $stockOutCost;

                        // dd(
                        //     'stock in'.'='.$stockInQty.' '.
                        //     'stockout'.'='.$stockOutQty.' '.
                        //     'stock in cost'.'='.$stockInCost.' '.
                        //     'stock out cost'.'='.$stockOutCost
                        // );

                        $item_record = Project_items_inventory_updates::where('project_items_id',$item_inventory->id)->orderBy('id', 'DESC')->first();

                       
                        Inventory_update::inventoryUpdate(
                            $item, //project id
                            Carbon::now(), //update date
                            "stock out", //stock udpate
                            $item_record->current_closing_stock ?? 0, //opening stock
                            $item_record->current_closing_stock_cost ?? 0,  //opening stock cost
                            $items_quantity[$index], //quantity type
                            $input_items['item_qunatity'], //updated stock   $stockQty
                            $items_quantity[$index] * $item_cost[$index],  //updated stock cost
                            $item_inventory_update->average_unit_cost, // cost per unit
                            $stockQty - $input_items['item_qunatity'], //current closing stock 
                            $stockCost - ($items_quantity[$index] * $item_cost[$index]), //current closing stock cost
                        );


                    } 
                    ##subtracting item issuance


                    ##saving items in issuance
                    $items_name = $request->item_name;
                    $items_quantity = $request->item_quantity;
                    $item_cost = $request->item_cost;
                    $save_items = array();

                    foreach($items_name as $index=>$item)
                    {  
                     
                        $save_items['item_name'] = "name";
                        $save_items['inventory_id'] = $item;
                        $save_items['item_qunatity'] = $items_quantity[$index];
                        $save_items['item_cost'] = $item_cost[$index];
                        $save_items['issuance_id'] = $item_issuance->id;

                        
                        $items = Project_inventory_items::firstOrCreate($save_items);
                    }
                    
                    ##saving items in issuance
                    DB::commit();

                    Session::flash('created', ' Project item issuance added Successfully');
                    
                    return redirect()->route('projectitemsissuance.index');

               // }
                // else{
                    
                //     Session::flash('error', 'Error adding item issuance');
                //     return redirect()->back()->withInput();
                // }
            
            }
            catch(Exception $e){
                DB::rollback();
                Session::flash('error', $e->getMessage());
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
            $quantity = 0; $total_price = 0.0;
            $project_items_issuance = Project_items_issuance::find($id);

            foreach($project_items_issuance->items as $index=>$item)
            {
                if($item->item_quantity > 0)
                {
                $quantity = $quantity + intval($item->item_qunatity);
                }
                $total_price = $total_price + intval($item->item_qunatity) * floatval($item->item_cost);
            }
         
            if($quantity > 0)
            {
                $avg_unit_cost = $total_price/$quantity;
            }
            else{
                $avg_unit_cost = 0;
            }

            $files = json_decode($project_items_issuance->file_attachments);

            return view('user.inventorymanagement.projectitemsissuance.view',compact('project_items_issuance','files','quantity','total_price','avg_unit_cost'));
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
            
            $projects = Project::where('status',1)->pluck('name','id')->toArray();

            $issuance = Project_items_issuance::findorFail($id);

            $project_id = $issuance->project_id;

            $project_items =  DB::table('project_items_inventory_projects')->where('project_id',$project_id)->pluck('project_items_id');
      
            $inventory_items = Project_items_inventory::whereIn('id',$project_items)->get();

            $files = json_decode($issuance->file_attachments);

            return view('user.inventorymanagement.projectitemsissuance.edit',compact('issuance','projects','inventory_items','project_items','files'));
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
            DB::beginTransaction();
            try {
            

                    $remove_images = array();  
                    $image_names = array();
                    $items_name = array();
                    $items_quantity = array();
                    $items_cost = array(); 
                    $new_images = array();
                    ##Checking if items are avaliable
                   
                    $id = decrypt($id);

                
                    $item_issuance = Project_items_issuance::find($id);

                    $images = json_decode($item_issuance->images);

                 

                    if($item_issuance)
                    {
                        ##checking items avaliable
                        if ($request->has(['item_name', 'item_quantity','item_cost'])) {
                
                            $items_name = $request->item_name;
                            $items_quantity = $request->item_quantity;
                            $item_cost = $request->item_cost;
                            
                            $insifficient = false; $insifficient_items = array();$insufficient_qty = array();
                            foreach($items_name as $index=>$item)
                            {  
                            
                                $input_items['item_name'] = $item;
                                $input_items['item_qunatity'] = $items_quantity[$index];

                                $stockInQty  = Project_items_inventory_updates::where([['project_items_id', $item], ['stock_update','stock in']])->sum('updated_stock');
                                $stockOutQty = Project_items_inventory_updates::where([['project_items_id', $item], ['stock_update','stock out']])->sum('updated_stock');
                                
                                
                                $item = Project_items_inventory::find($item);

                                $stockQty =  $stockInQty - $stockOutQty;

                                if($item)
                                {
                                    if($input_items['item_qunatity']<= $stockQty)
                                    {
                                        continue;
                                    }
                                    else{
                                        $insifficient = true;
                                        $item = " ".$item->item_name." ";
                                        $qty = "avalible QTY is = ".$stockQty.' ';

                                        array_push($insifficient_items,$item);
                                        array_push($insufficient_qty,$qty);

                                
                                    }
                                }
                            }
            
                            if($insifficient)
                            {
                                // Session::flash('warning',implode(',',$insifficient_items).' has Insufficient quantity!');
                                Session::flash('warning',implode(',',$insifficient_items).' '.implode(',',$insufficient_qty));
                                return redirect()->back()->withInput();
                            }
                        }
                        ##checking items avaliable

                        ##removing selected images
                        if(isset($request->remove_images))
                        {
                            $remove_images = explode(',',$request->remove_images);
                            foreach($remove_images as $img)
                            {
                                if(!preg_match("/\.(pdf)$/", $img))
                                {
                                    $path = ('/items_issuance/'.$img);
                                    if (Storage::disk('public')->exists($path))
                                    {
                                        Storage::disk('public')->delete($path);
                                    } 
                                }
                                else {
                                    $path = ('/items_issuance/PDF/'.$img);
                                
                                    if (Storage::disk('public')->exists($path))
                                    {
                                        Storage::disk('public')->delete($path);
                                    } 
                                }  
                            }

                        }
                
                        ##saving images
                        if($request->hasfile('images'))
                        {   
                            foreach($request->file('images') as $image)
                            { 

                            if($image->getClientOriginalExtension() == 'pdf')
                            {
                                $fileName = rand(10,5000).time() . '.' . $image->getClientOriginalExtension();
                                $store = Storage::disk('local')->put('public/items_issuance/PDF'.'/'.$fileName,file_get_contents($image),'public');
                            }
                            else
                            {
                                $image = $image;
                                $fileName = rand(10,5000).time() . '.' . $image->getClientOriginalExtension();
                    
                                $img = Image::make($image->getRealPath());
                                $img->resize(300, 300, function ($constraint) {
                                    $constraint->aspectRatio();                 
                                });
                    
                                $img->stream();
                                Storage::disk('local')->put('public/items_issuance'.'/'.$fileName, $img, 'public');
                            }

                                array_push($image_names,$fileName);
                                $fileName = '';
                            }  
                            

                            if($images)
                            {
                                foreach($images as $img)
                                {
                                    if (!in_array($img,$remove_images)) {
                                    array_push($new_images,$img);
                                    }
                                }
                            }
                           
    
                            $new_images = array_merge($new_images,$image_names);
                            $input['file_attachments'] =  $new_images;

                        }
                        
                        $input['date_of_issuance'] = $request->date_of_issuance;
                        $input['title'] = $request->title;
                        $input['project_id'] = $request->project_id;
                        $input['region'] = $request->region;
                        $input['issued_person_id'] = $request->issued_person_id;
                        $input['comments'] = $request->comments;
                        $input['issued_items_cost'] = 0;

                        // updating issuance
                        $item_issuance->update($input);

                        $item_issuance->refresh();

                        ##subtracting item issuance

                        if ($request->has(['item_name','item_quantity','item_cost'])) {

                            foreach($items_name as $index=>$item)
                            {  
                                $input_items['item_name'] = $item;
                                $input_items['item_qunatity'] = $items_quantity[$index];
                                $input_items['item_cost'] = $item_cost[$index];
                                // $item = Project_items_inventory::find($item);
                                // $item->current_balance_item = $item->current_balance_item - $items_quantity[$index];
                                // $item->save();

                                $item_inventory_update = Project_items_inventory::find($item);

                                $stockInQty  = Project_items_inventory_updates::where([['project_items_id', $item], ['stock_update','stock in']])->sum('updated_stock');
                                $stockOutQty = Project_items_inventory_updates::where([['project_items_id', $item], ['stock_update','stock out']])->sum('updated_stock');
                                
                                $stockInCost  = Project_items_inventory_updates::where([['project_items_id', $item], ['stock_update','stock in']])->sum('updated_stock_cost');
                                $stockOutCost = Project_items_inventory_updates::where([['project_items_id', $item], ['stock_update','stock out']])->sum('updated_stock_cost');

                                $stockQty =  $stockInQty - $stockOutQty;
    
                                $stockCost = $stockInCost - $stockOutCost;

                                Inventory_update::inventoryUpdate(
                                    $item, //project id
                                    Carbon::now(), //update date
                                    "stock out", //stock udpate
                                    0, //opening stock
                                    0,  //opening stock cost
                                    $items_quantity[$index], //quantity type
                                    $input_items['item_qunatity'], //updated stock   $stockQty
                                    $items_quantity[$index] * $item_cost[$index],  //updated stock cost
                                    $item_inventory_update->average_unit_cost, // cost per unit
                                    $stockQty - $input_items['item_qunatity'], //current closing stock 
                                    $stockCost - ($items_quantity[$index] * $item_cost[$index]), //current closing stock cost
                                );

                            } 
                        
                            ##subtracting item issuance


                            ##saving items in issuance
                            $items_name = $request->item_name;
                            $items_quantity = $request->item_quantity;
                            $item_cost = $request->item_cost;
                            $save_items = array();

                     
                            
                            foreach($items_name as $index=>$item)
                            {  
                                $save_items['item_name'] = "name";
                                $save_items['inventory_id'] = $item;
                                $save_items['item_qunatity'] = $items_quantity[$index];
                                $save_items['item_cost'] = $item_cost[$index];
                                $save_items['issuance_id'] = $item_issuance->id;
                                $items = Project_inventory_items::Create($save_items);
                              
                            }
                        }
                        DB::commit();

                        Session::flash('updated', 'Item issuance Edited Sucessfully');
                        return redirect()->route('projectitemsissuance.index');
                    }
                    else{
                        Session::flash('error', 'Item Issuance Not found');
                        return redirect()->back();
                    }



            }
            catch(Exception $e){
                DB::rollback();
                Session::flash('error', $e->getMessage());
                return redirect()->back()->withInput();
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
    public function destroy(Request $request, $id)
    {
        $id = $request->id;
        if(Auth::user()->can('manage-project-item-inventory'))
        {
           try {    
                $item_issuance = Project_items_issuance::find($id);
            
                if($item_issuance)
                {
                   $item_issuance->delete();
                    return response()->json(['success' => true, 'message' => 'Project item Issuance deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Project item Issuance deletion failed'], 422);
                }
               
           }
           catch(Exception $e){
                Session::flash('error', 'Project item issuance not Deleted');
                return redirect()->back();
           }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    public function getProjects(Request $request){
        $project_id = $request->project_id;
        $project_items =  DB::table('project_items_inventory_projects')->where('project_id',$project_id)->pluck('project_items_id');
        
        //return $project_items;
        // $inventory_items = Project_items_inventory_updates::whereIn('project_items_inventory_updates.project_items_id',$project_items)->where('stock_update','stock in')->where('project_items_inventory_updates.stock_update','stock in')->join('project_items_inventories','project_items_inventory_updates.project_items_id', '=', 'project_items_inventories.id')->get();       
        
        $inventory_items = Project_items_inventory::whereIn('id',$project_items)->get();       
        
        //return $inventory_items;
        return response()->json(['success' => true, 'items' => $inventory_items], 200);
    }

    public function getEmployees(Request $request){
        $project_id = $request->project_id;
        
        $employees = Employeemanagement::where('project_id',$project_id)->get();
    
        return response()->json(['success' => true, 'employees' => $employees], 200);
    }
}
