<?php

namespace App\Http\Controllers\User\fuelmanagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fuel_items;
use App\Models\Project;
use App\Models\Suppliers;
use Auth;
use Session;
use Exception;
use DB;

class FuelitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('manage-fuel'))
        {
            try{
                $fuel_item = Fuel_items::orderBy('id','Desc')->get();
                if($fuel_item)
                {
                    return view('user.fuelmanagement.fuelitem.index',compact('fuel_item'));
                }
                else{
                    Session::flash('warning','No Fuel Items found');
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
        if(Auth::user()->can('manage-fuel'))
        {
            $suppliers = Suppliers::where('status',1)->where('suppliers_types_id','2')->pluck('name','id')->toArray();
           // $projects = Project::where('status',1)->pluck('name','id')->toArray();
           
            return view('user.fuelmanagement.fuelitem.create',compact('suppliers'));
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
        if(Auth::user()->can('manage-fuel'))
        {
            try{

                DB::beginTransaction();
                $current_stock_cost_format = (int)str_replace(',', '', $request->current_stock_cost);
                $monthly_limit_rupees_format = (int)str_replace(',', '', $request->monthly_limit_rupees);


                $input['item_code'] = $request->item_code;
                $input['item_name'] = $request->item_name;
               // $input['project_id'] = $request->project_id ?? ;
                $input['supplier_id'] = $request->supplier_id;
                $input['current_balance_item'] = $request->current_balance_item ?? 0;
                $input['current_stock_cost'] = $current_stock_cost_format ?? 0;
                $input['average_unit_cost'] = 0;
                $input['fuel_type'] = $request->fuel_type;
                $input['fuel_card_no'] = $request->fuel_card_no ?? '';
                $input['date_of_addition'] = $request->date_of_addition;
                $input['monthly_limit'] = $request->monthly_limit;
                $input['monthly_limit_rupees'] = $monthly_limit_rupees_format;
                $input['card_issue_date'] = $request->card_issue_date;
                $input['card_expiry_date'] = $request->card_expiry_date;

                $input['fuel_type_card'] = $request->fuel_type_card;
                $input['person_name'] = $request->person_name;

                $input['comments'] = $request->comments;


                $check_item_Code = Fuel_items::where('item_code',$request->item_code)->count();

                if($check_item_Code >= 1)
                {
                    $check_item_Code = Fuel_items::where('item_code',$request->item_code)->first();
                    ##calculating average unit cost
                    $remaining_items_cost = $check_item_Code->current_stock_cost;
                    $remaining_items_qty = $check_item_Code->current_balance_item;
                    $new_items_cost = $current_stock_cost_format;
                    $new_items_qty = $request->current_balance_item;
                    $avg_stock_cost = ($remaining_items_cost + $new_items_cost)/($new_items_qty + $remaining_items_qty);
                    $input['current_balance_item'] = $request->current_balance_item + $check_item_Code->current_balance_item;
                    $input['average_unit_cost'] = $avg_stock_cost;
                   
                    $fuel_item = Fuel_items::updateOrCreate(['item_code'=>$request->item_code],$input);

                    if($fuel_item)
                    {

                        Session::flash('warning','Fuel Item Updated!');
                       // return redirect()->back()->withInput(); 
                       return redirect()->route('fuelitem.index');
  
                    }


                  
                }

                $fuel_item = Fuel_items::Create($input);

                if($fuel_item->wasRecentlyCreated)
                {
                    DB::commit();

                    Session::flash('created', 'Fuel Item Added successfully!');
                    return redirect()->route('fuelitem.index');
                }
                else{
                   
                    Session::flash('error', 'Fuel Item not added');
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
        if(Auth::user()->can('manage-fuel'))
        {
            $id = decrypt($id);
            $fuel_item = Fuel_items::find($id);
            
            return view('user.fuelmanagement.fuelitem.view',compact('fuel_item'));
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
        if(Auth::user()->can('manage-fuel'))
        {
          try{
                $id = decrypt($id);
                $fuel_item = Fuel_items::find($id);
                $suppliers = Suppliers::where('status',1)->where('suppliers_types_id','2')->pluck('name','id')->toArray();
               // $projects = Project::where('status',1)->pluck('name','id')->toArray();  
                return view('user.fuelmanagement.fuelitem.edit',compact('suppliers','fuel_item'));
          }
          catch(Exception $e){
                Session::flash('error','Fuel Item not found!');
                return redirect()->back();
          }
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

        if(Auth::user()->can('manage-fuel'))
        {
            try{

                $id = decrypt($id);
                
                $fuel_item = Fuel_items::find($id);

                if($fuel_item)
                {
                    $input['item_code'] = $request->item_code;
                    $input['item_name'] = $request->item_name;
                    $input['project_id'] = $request->project_id;
                    $input['supplier_id'] = $request->supplier_id;
                    $input['current_balance_item'] = $request->current_balance_item;
                    $input['current_stock_cost'] = $request->current_stock_cost;
                    $input['fuel_type'] = $request->fuel_type;
                    $input['fuel_card_no'] = $request->fuel_card_no;
                    $input['date_of_addition'] = $request->date_of_addition;
                    $input['monthly_limit'] = $request->monthly_limit;
                    
                    $input['monthly_limit_rupees'] = $request->monthly_limit_rupees;
                    $input['card_issue_date'] = $request->card_issue_date;
                    $input['card_expiry_date'] = $request->card_expiry_date;

                    $input['comments'] = $request->comments;
    
    
                    $check_item_Code = Fuel_items::where('item_code',$request->item_code)->whereNotIn('id',[$id])->count();
    
                    if($check_item_Code >= 1)
                    {
                        Session::flash('warning','Item Code already exist!');
                        return redirect()->back()->withInput();
                    }
    
                    $fuel_item->update($input);
                    
                    Session::flash('updated', 'Fuel Item updated successfully!');
                    return redirect()->route('fuelitem.index');
    
                
                }
                else{

                    Session::flash('error','Fuel Item not found!');
                    return redirect()->back();
                }
      
            }
            catch(Exception $e){
           
                Session::flash('error', 'Fuel Item not added');
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
        if(Auth::user()->can('manage-fuel'))
        {
           try {    
                $Fuel_items = Fuel_items::find($id);
            
                if($Fuel_items)
                {
                    $Fuel_items->delete();
                    return response()->json(['success' => true, 'message' => 'Fuel Item deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Fuel Item deletion failed'], 422);
                }
               
           }
           catch(Exception $e){
                Session::flash('error', 'Fuel Item not Deleted');
                return redirect()->back();
           }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }
}
