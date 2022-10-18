<?php

namespace App\Http\Controllers\User\inventorymanagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Project_inventory_items;
use App\Models\Mainterance_items_inventory;
use App\Models\Mainterance_items_consumption;
use App\Models\Mainterance_sub_item_consumption;
use App\Models\Damcon_asssets;
use App\Models\maintenance_items_inventory_updates;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Traits\MaintenancetemsInventoryTraitUpdates as MaintenanaceInventoryupdate;
use Carbon\Carbon;
use DB;
use Auth;
use Session;
use Exception;
use File;

class MaintenanaceConsumptionController extends Controller
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
                $maintenanace_item_consumption = Mainterance_items_consumption::orderBy('id','Desc')->get();
                if($maintenanace_item_consumption)
                {
                    return view('user.inventorymanagement.maintenanaceitemconsumption.index',compact('maintenanace_item_consumption'));
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
        if(Auth::user()->can('manage-maintenance-item-inventory'))
        {
 
            $projects = Project::where('status',1)->pluck('name','id')->toArray();

            $assets = Damcon_asssets::pluck('registration_no','id')->toArray();

            $items = Mainterance_items_inventory::all();
           

            // ->selectRaw(DB::raw('SUM(maintenance_items_inventory_updates.updated_stock)'))
            // ->havingRaw('maintenance_items_inventory_updates.stock_update = stock in')
            // ->get();
            // dd($items);

            return view('user.inventorymanagement.maintenanaceitemconsumption.create',compact('projects','assets','items'));
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
        // dd($request->all());
        if(Auth::user()->can('manage-maintenance-item-inventory'))
        {
            DB::beginTransaction();
            try{

            
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
                    $input_items['item_quantity'] = $items_quantity[$index];

                    $stockInQty  = maintenance_items_inventory_updates::where([['maintenance_item_id', $item], ['stock_update','stock in']])->sum('updated_stock');
                    $stockOutQty = maintenance_items_inventory_updates::where([['maintenance_item_id', $item], ['stock_update','stock out']])->sum('updated_stock');
                    
                    $item = Mainterance_items_inventory::find($item);

                    $stockQty =  $stockInQty - $stockOutQty;

                    if($item)
                    {
                        if($input_items['item_quantity']<= $stockQty)
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
                    //Session::flash('warning',implode(',',$insifficient_items).' has Insufficient quantity!');
                    Session::flash('warning',implode(',',$insifficient_items).' '.implode(',',$insufficient_qty).')');

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
                             $store = Storage::disk('local')->put('public/maintenance_items_issuance/PDF'.'/'.$fileName,file_get_contents($image),'public');
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
                             Storage::disk('local')->put('public/maintenance_items_issuance'.'/'.$fileName, $img, 'public');
                         }
 
                          array_push($image_names,$fileName);
                          $fileName = '';
                     }   
                     
                    
                     $input['file_attachments'] = json_encode($image_names);
                  }
                  
                ##saving imagesend

                ##saving item issuance 
                $input['date_of_issuance'] = $request->date_of_issuance;
                $input['title'] = $request->title;
                $input['damcon_assset_id'] = $request->damcon_assset_id;
                $input['current_possession'] = $request->current_possession;
                $input['project_id'] = $request->project_id;
                $input['milage_hours'] = $request->milage_hours;
                $input['issued_person_id'] = $request->issued_person_id;
                $input['comments'] = $request->comments;
                $input['issued_items_cost'] = 0;


                $item_consumtion = Mainterance_items_consumption::firstOrCreate($input);
                if($item_consumtion->wasRecentlyCreated)
                {
                    $item_consumtion->refresh();

                    ##subtracting maintenanace item consumption

                    foreach($items_name as $index=>$item)
                    {  
                        $input_items['item_name'] = $item;
                        $input_items['item_quantity'] = $items_quantity[$index];
                        $input_items['item_cost'] = $item_cost[$index];
                        // $item = Mainterance_items_inventory::find($item);
                        // $item->current_balance_item = $item->current_balance_item - $items_quantity[$index];
                        // $item->save();

                        $maintenance_inventory_update = Mainterance_items_inventory::find($item);

                        $stockInQty  = maintenance_items_inventory_updates::where([['maintenance_item_id', $item], ['stock_update','stock in']])->sum('updated_stock');
                        $stockOutQty = maintenance_items_inventory_updates::where([['maintenance_item_id', $item], ['stock_update','stock out']])->sum('updated_stock');
                        
                        $stockInCost  = maintenance_items_inventory_updates::where([['maintenance_item_id', $item], ['stock_update','stock in']])->sum('updated_stock_cost');
                        $stockOutCost = maintenance_items_inventory_updates::where([['maintenance_item_id', $item], ['stock_update','stock out']])->sum('updated_stock_cost');
    
    
                        $stockQty =  $stockInQty - $stockOutQty;
    
                        $stockCost = $stockInCost - $stockOutCost;
                       
                        $item_record = maintenance_items_inventory_updates::where('maintenance_item_id',$item)->orderBy('id', 'DESC')->first();

                        MaintenanaceInventoryupdate::maintenanceinventoryUpdate(
                            $item, //project id
                            Carbon::now(), //update date
                            "stock out", //stock udpate
                            $item_record->current_closing_stock ?? 0, //opening stock
                            $item_record->current_closing_stock_cost ?? 0,  //opening stock cost
                            $items_quantity[$index], //quantity type
                            $input_items['item_quantity'], //updated stock   $stockQty
                            $items_quantity[$index] * $item_cost[$index],  //updated stock cost
                            $maintenance_inventory_update->average_unit_cost, // cost per unit
                            $stockQty - $input_items['item_quantity'], //current closing stock 
                            $stockCost - ($items_quantity[$index] * $item_cost[$index]), //current closing stock cost
                        );



                    } 

                    ##subtracting maintenanace item consumption

                    ##saving items in consumption
                    $items_name = $request->item_name;
                    $items_quantity = $request->item_quantity;
                    $item_cost = $request->item_cost;
                    $save_items = array();

                    foreach($items_name as $index=>$item)
                    {  
                     
                        $save_items['item_name'] = "name";
                        $save_items['inventory_id'] = $item;
                        $save_items['item_quantity'] = $items_quantity[$index];
                        $save_items['item_cost'] = $item_cost[$index];
                        $save_items['issuance_id'] = $item_consumtion->id;

                        
                        $items = Mainterance_sub_item_consumption::firstOrCreate($save_items);
                    }
                    ##saving items in consumption

                    DB::commit();
                    Session::flash('created', ' Maintenanace Consumption Added Successfully');
                    
                    return redirect()->route('maintenanaceitemconsumption.index');

                }
                else{
                    
                    Session::flash('error', 'Error adding maintenance item consumption');
                    return redirect()->back()->withInput();
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
            $quantity = 0; $total_price = 0.0;
            $main_items_issuance = Mainterance_items_consumption::find($id);
            $files = json_decode($main_items_issuance->file_attachments);

            foreach($main_items_issuance->items as $index=>$item)
            { 
                if($item->item_quantity > 0)
                {
                    $quantity = $quantity + intval($item->item_quantity);
                    
                }
                $total_price = $total_price + intval($item->item_quantity) * floatval($item->item_cost);

            }
            
            if($quantity > 0)
            {
                $avg_unit_cost = $total_price/$quantity;
            }
            else{
                $avg_unit_cost = 0;
            }

            return view('user.inventorymanagement.maintenanaceitemconsumption.view',compact('main_items_issuance','files','quantity','avg_unit_cost'));
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

            $projects = Project::where('status',1)->pluck('name','id')->toArray();

            $assets = Damcon_asssets::pluck('registration_no','id')->toArray();

            $items = Mainterance_items_inventory::all();

            $consumption_item = Mainterance_items_consumption::findorFail($id);
            
            $files = json_decode($consumption_item->file_attachments);
         
            $sub_items = Mainterance_sub_item_consumption::where('issuance_id',$consumption_item->id)->get();

            return view('user.inventorymanagement.maintenanaceitemconsumption.edit',compact('projects','assets','items','consumption_item','sub_items','files'));

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

        if(Auth::user()->can('manage-maintenance-item-inventory'))
        {
            DB::beginTransaction();
            try 
                {
                    
                    $remove_images = array();  
                    $image_names = array();
                    $items_name = array();
                    $items_quantity = array();
                    $items_cost = array(); 
                    $new_images = array();

                    $id = decrypt($id);
                    $item_consumption = Mainterance_items_consumption::find($id);
                    $images = json_decode($item_consumption->file_attachments);

                    if($item_consumption)
                    {

                        if ($request->has(['item_name', 'item_quantity','item_cost'])) {
                
                            $items_name = $request->item_name;
                            $items_quantity = $request->item_quantity;
                            $item_cost = $request->item_cost;
                            
                            $insifficient = false; $insifficient_items = array(); $insufficient_qty = array();
                            foreach($items_name as $index=>$item)
                            {  
                            
                                $input_items['item_name'] = $item;
                                $input_items['item_quantity'] = $items_quantity[$index];

                                $stockInQty  = maintenance_items_inventory_updates::where([['maintenance_item_id', $item], ['stock_update','stock in']])->sum('updated_stock');
                                $stockOutQty = maintenance_items_inventory_updates::where([['maintenance_item_id', $item], ['stock_update','stock out']])->sum('updated_stock');

                                $item = Mainterance_items_inventory::find($item);

                                $stockQty =  $stockInQty - $stockOutQty;

                                if($item)
                                {
                                    if($input_items['item_quantity']<= $item->current_balance_item)
                                    {
                                        continue;
                                    }
                                    else{
                                        $insifficient = true;
                                        $item = " ".$item->item_name." ";
                                        $qty = "avalible QTY is = ".$stockQty.' ';
                                        array_push($insufficient_qty,$qty);
                                        array_push($insifficient_items,$item);
                                
                                    }
                                }
                            }
            
                            if($insifficient)
                            {
                                // Session::flash('warning',implode(',',$insifficient_items).' has Insufficient quantity!');
                                Session::flash('warning',implode(',',$insifficient_items).' '.implode(',',$insufficient_qty).')');
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
                         ##saving item issuance 
                        $input['date_of_issuance'] = $request->date_of_issuance;
                        $input['title'] = $request->title;
                        $input['damcon_assset_id'] = $request->damcon_assset_id;
                        $input['current_possession'] = $request->current_possession;
                        $input['project_id'] = $request->project_id;
                        $input['milage_hours'] = $request->milage_hours;
                        $input['issued_person_id'] = $request->issued_person_id;
                        $input['comments'] = $request->comments;
                        $input['issued_items_cost'] = 0;
                      
                        $item_consumption->update($input);
                        $item_consumption->refresh();

                        ##subtracting item issuance
                        
                        if ($request->has(['item_name','item_quantity','item_cost'])) {

                            foreach($items_name as $index=>$item)
                            {  
                                $input_items['item_name'] = $item;
                                $input_items['item_quantity'] = $items_quantity[$index];
                                $input_items['item_cost'] = $item_cost[$index];
                                // $item = Mainterance_items_inventory::find($item);
                                // $item->current_balance_item = $item->current_balance_item - $items_quantity[$index];
                                // $item->save();

                                $maintenance_inventory_update = Mainterance_items_inventory::find($item);

                                $stockInQty  = maintenance_items_inventory_updates::where([['maintenance_item_id', $item], ['stock_update','stock in']])->sum('updated_stock');
                                $stockOutQty = maintenance_items_inventory_updates::where([['maintenance_item_id', $item], ['stock_update','stock out']])->sum('updated_stock');
                                
                                $stockInCost  = maintenance_items_inventory_updates::where([['maintenance_item_id', $item], ['stock_update','stock in']])->sum('updated_stock_cost');
                                $stockOutCost = maintenance_items_inventory_updates::where([['maintenance_item_id', $item], ['stock_update','stock out']])->sum('updated_stock_cost');
            
            
                                $stockQty =  $stockInQty - $stockOutQty;
                                $stockCost = $stockInCost - $stockOutCost;

                                
                                MaintenanaceInventoryupdate::maintenanceinventoryUpdate(
                                    $item, //project id
                                    Carbon::now(), //update date
                                    "stock out", //stock udpate
                                    0, //opening stock
                                    0,  //opening stock cost
                                    $items_quantity[$index], //quantity type
                                    $input_items['item_quantity'], //updated stock   $stockQty
                                    $items_quantity[$index] * $item_cost[$index],  //updated stock cost
                                    $maintenance_inventory_update->average_unit_cost, // cost per unit
                                    $stockQty - $input_items['item_quantity'], //current closing stock 
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
                                $save_items['item_quantity'] = $items_quantity[$index];
                                $save_items['item_cost'] = $item_cost[$index];
                                $save_items['issuance_id'] = $item_consumption->id;
                                $items = Mainterance_sub_item_consumption::Create($save_items);
                              
                            }
                        }
                        DB::commit();
                        Session::flash('updated', 'Maintenance Item Edited Sucessfully');
                        return redirect()->route('maintenanaceitemconsumption.index');


                    }
                    else{
                        Session::flash('error', 'Maintenance Item Not found');
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
    public function destroy(Request $request,$id)
    {
        $id = $request->id;
        if(Auth::user()->can('manage-project-item-inventory'))
        {
           try {    
                $item_issuance = Mainterance_items_consumption::find($id);
            
                if($item_issuance)
                {
                   $item_issuance->delete();
                    return response()->json(['success' => true, 'message' => 'Maintenance item Consumption deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Maintenance item Consumption deletion failed'], 422);
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
}
