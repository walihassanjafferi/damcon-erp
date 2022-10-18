<?php

namespace App\Http\Controllers\User\fuelmanagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Suppliers;
use App\Models\Taxation_bodies;
use App\Models\Fuel_items;
use App\Models\Fuel_consumption;
use App\Models\Damcon_asssets;
use App\Models\RentalItemsManagement;
use App\Models\CustomerAssetsManagement;
use App\Traits\FileAttachmentsTrait as FileUploader;
use App\Traits\SupplierTaxledgerTrait as SupplierLedger;
use Auth;
use Session;
use Exception;
use DataTables;
use DB;

class FuelConsumptionController extends Controller
{

    private $permission = 'manage-fuel-item-consumption';
    private $filePath = 'user.fuelmanagement.fuelconsumption';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can($this->permission))
        {
            return view($this->filePath.'.index');
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
        //
        if(Auth::user()->can($this->permission))
        {
            $suppliers = Suppliers::where('status',1)->where('suppliers_types_id','2')->pluck('name','id')->toArray();
            $projects = Project::where('status',1)->pluck('name','id')->toArray();
            $tax_bodies = Taxation_bodies::pluck('name','id')->toArray();
            return view($this->filePath.'.create',compact('suppliers','projects','tax_bodies'));
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
        DB::beginTransaction();
        
        if(Auth::user()->can($this->permission))
        {
            try{
                

                $amount_with_sale_tax = (int)str_replace(',', '', $request->amount_with_sale_tax);
                // checking fueling item exist or not

                $fueling_item_code = $request->fuel_item_code;
                $get_fueling_item = Fuel_items::find($fueling_item_code);
                $fuel_date_of_addition = $get_fueling_item->date_of_addition;
                $fuel_item_limit = $get_fueling_item->monthly_limit;

                $consumption_month = $request->consumption_month;

                $fuel_item_rupees = $get_fueling_item->monthly_limit_rupees;
               /// $checking_fuel_consumption
               // dd(Fuel_consumption::where('fuel_item_code')->where('consumption_month',$consumption_month)->sum());
                
               /**Check with fuel consumption accoding to liters */
            //    $check_fuel_consumption_liter = Fuel_consumption::where('fuel_item_code',$fueling_item_code)->where('consumption_month',$consumption_month)->sum('quantity_in_liter');
            //     if($check_fuel_consumption_liter && ($check_fuel_consumption_liter >= $fuel_item_limit))
            //     {
            //         Session::flash('warning','Fuel Item Monthly limit reached!');
            //         return redirect()->back()->withInput();
            //     }
            //     else{
            //         $qty_in_liter = $request->quantity_in_liter + $check_fuel_consumption_liter;
            //         if($qty_in_liter > $fuel_item_limit)
            //         {
            //             Session::flash('warning','Fuel QTY is greater than fuel Item Monthly limit! Monthly limit is '.$fuel_item_limit.' liters');
            //             return redirect()->back()->withInput();
            //         }
            //     }

             /**Check with fuel consumption accoding to liters */

            //  Checking fuel consumption according to rupees//

                $check_fuel_consumption_rupeess = Fuel_consumption::where('fuel_item_code',$fueling_item_code)->where('consumption_month',$consumption_month)->sum('amount_with_sale_tax');
                if($check_fuel_consumption_rupeess && ($check_fuel_consumption_rupeess >= $fuel_item_rupees))
                {
                    Session::flash('warning','Fuel Item Monthly limit reached!');
                    return redirect()->back()->withInput();
                }
                else{

                   
                    $rupess_limit = $amount_with_sale_tax + $check_fuel_consumption_rupeess;
                   
                    if($rupess_limit > (double)$fuel_item_rupees)
                    {
                        Session::flash('warning','Fuel Amount is greater than fuel Rupee Monthly limit! Monthly limit is '.$fuel_item_rupees.'PKR');
                        return redirect()->back()->withInput();
                    }


                }




                // checking fueling item exist or not

                $fuel_item = Fuel_items::find($request->fuel_item_code);

                // if($request->quantity_in_liter > $fuel_item->current_balance_item)
                // {
                //     Session::flash('error','Fuel Quantity is not sufficient in a fuel Item!');
                //     return redirect()->back()->withInput();
                // }

                $input['title_po_number'] = $request->title_po_number;
                $input['project_id'] = $request->project_id;
                $input['date_of_entry'] = $request->date_of_entry;
                $input['entry_person'] = $request->entry_person;
                $input['driver_person'] = $request->driver_person;
                $input['asset_type'] = $request->asset_type;
                $input['fueling_item_id'] = $request->fueling_item_id;
                $input['fuel_item_code'] = $request->fuel_item_code;
                $input['supplier_id'] = $request->supplier_id;
                $input['consumption_month'] = $request->consumption_month;
                $input['quantity_in_liter'] = $request->quantity_in_liter;
                $input['amount_with_sale_tax'] = $amount_with_sale_tax;
                
                $input['rate_fuel_per_liter'] = $request->rate_fuel_per_liter;
                $input['milage_hours'] = $request->milage_hours;
                $input['oil_filter_due_date'] = $request->oil_filter_due_date;
                $input['tax_body_id'] = $request->tax_body_id;
                $input['taxation_month'] = $request->taxation_month;
                $input['tax_body_percentage'] = $request->tax_body_percentage;
                $input['comments'] = $request->comments;
                $input['sales_tax_withheld_at_source_per'] = $request->sales_tax_withheld_at_source_per;
                $input['supplier_withheld_tax_1_deduction_per'] = $request->supplier_withheld_tax_1_deduction_per;
                $input['item_type'] = $request->item_type;

                $image_names=[];

                 //Upload Files
                 if($request->hasfile('document_file'))
                 {
                     foreach($request->file('document_file') as $image)
                     {
                         $filename = FileUploader::uploadFile($image,"fuel_consumption","Fuel_consumption");
                         array_push($image_names,$filename);
                     }
                     $input['file_attachments'] = json_encode($image_names);
                }
                 
               
                 $fuel_consumption = Fuel_consumption::Create($input);

                 /* removing fuel items quantity */
                //  $fuel_item->current_balance_item = $fuel_item->current_balance_item - $request->quantity_in_liter;
                //  $fuel_item->save();

                 /* removing fuel items quantity */


                 if($fuel_consumption->wasRecentlyCreated)
                 {

                    ## updating vehiclde total milage/hrs

                    if($request->asset_type == "damcon")
                    {
                        if($request->filled('asset_total_km'))
                        {
                            $damcon_asset = Damcon_asssets::find($fuel_consumption->fueling_item_id);
                            $damcon_asset->asset_total_km_hr = $request->asset_total_km;
                            $damcon_asset->save();
                        }

                    }
                    else if($request->asset_type == "customer"){

                    }





                    ##update sales_tax_withheld_at_source_per to supplier tax ledger
                    $supplier_ledger = SupplierLedger::add_supplier_tax(
                        $fuel_consumption->supplier_id,
                        $fuel_consumption->id,
                        "payment_in",
                        'fuel_consumption',
                        'Sales Tax Withheld at Source',
                        $fuel_consumption->sales_tax_withheld_at_source_per
                    );

                    ##Supplier withheld Tax 1 Deduction
                    $supplier_ledger = SupplierLedger::add_supplier_tax(
                        $fuel_consumption->supplier_id,
                        $fuel_consumption->id,
                        "payment_in",
                        'fuel_consumption',
                        'Supplier withheld Tax 1 Deduction',
                        $fuel_consumption->supplier_withheld_tax_1_deduction_per
                    );


                    DB::commit();

                    Session::flash('created', 'Fuel Consumption Added successfully!');
                    return redirect()->route('fuelconsumption.index');
                 }
                 else{
                    DB::rollback();
                    Session::flash('error', 'Fuel consumption not added');
                    return redirect()->back()->withInput();
                }

            }
            catch(Exception $e)
            {  
                DB::rollback();
                Session::flash('error', $e->getMessage());
                return redirect()->back()->withInput();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }


    public function getFuelConsumption(Request $request){
        if(Auth::user()->can($this->permission))
        {
            if ($request->ajax()) {
                $data = Fuel_consumption::orderBy('id','Desc')->get();

                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('fuelconsumption.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                                  <a href="'.route('fuelconsumption.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;
                                  <a  onclick="DeleteFuelConsumption('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>';
                    return $actionBtn;
                })->addColumn('checkbox',function($row){
                    $checkBtn = '<input type="checkbox" class="order_check"  value="'.$row->id.'">';
                    return $checkBtn;
                })
                ->addColumn('rowid',function($row){
                    $checkBtn = $row->id;
                    return $checkBtn;
                })
                ->addColumn('fueling_item_name',function($row){
                    $checkBtn = $row->assetItem->asset_item_id ?? '';
                    return $checkBtn;
                })
                ->addColumn('fueling_item_code',function($row){
                    $checkBtn = $row->fuelItem->item_code ?? '';
                    return $checkBtn;
                }) 
                ->addColumn('supplier',function($row){
                    $checkBtn = $row->supplier->name;
                    return $checkBtn;
                }) 
                ->addColumn('consumption_month1',function($row){
                    $checkBtn = $row->consumption_month;
                    return '<p class="date_hide">'.$checkBtn.'</p>';
                })
                ->addColumn('consumption_month',function($row){
                    $checkBtn = date('d-M-Y',strtotime($row->consumption_month));
                    return $checkBtn;
                })
                ->addColumn('qty_in_liter',function($row){
                    $checkBtn = $row->quantity_in_liter;
                    return $checkBtn;
                })
                ->addColumn('rate_of_fuel',function($row){
                    $checkBtn = $row->rate_fuel_per_liter;
                    return $checkBtn;
                })
                ->addColumn('title_po',function($row){
                    $checkBtn = $row->title_po_number;
                    return $checkBtn;
                })

                ->rawColumns(['action','checkbox','rowid','fueling_item_code','fueling_item_name','supplier','consumption_month','qty_in_liter','rate_of_fuel','title_po', 'consumption_month1'])
                ->make(true);
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
        if(Auth::user()->can($this->permission))
        {
            $id = decrypt($id);
            $fuel_consumption = Fuel_consumption::find($id);
            $current_milage = $fuel_consumption->milage_hours;
            ##get previous consumption
            $previous_consumption = Fuel_consumption::where('fueling_item_id',$fuel_consumption->fueling_item_id)->orderBy('created_at','desc')->skip(1)->take(1)->pluck('milage_hours');
           
            ##fuel amount W/O Tax
            $fuel_amount_without_tax = $fuel_consumption->amount_with_sale_tax * (1+($fuel_consumption->tax_body_percentage/100));
            ##tax amount
            $tax_amount = $fuel_amount_without_tax * ($fuel_consumption->tax_body_percentage/100);
            ##total price after deductions
            $total_after_deductions = $fuel_consumption->amount_with_sale_tax - $fuel_consumption->amount_with_sale_tax - $fuel_consumption->supplier_withheld_tax_1_deduction_per;
        
            ##milage hours during month
            $milage_hours_during_month = $current_milage - ($previous_consumption[0] ?? 0);
        

            ##milage hour per liter
            $milage_hours_per_liter = ($current_milage / $fuel_consumption->quantity_in_liter);         
            
            ##fuel expense per unit
            $fuel_expense = ($fuel_consumption->rate_fuel_per_liter / $current_milage);
            
            return view('user.fuelmanagement.fuelconsumption.view',compact('fuel_consumption',
            'fuel_amount_without_tax','tax_amount','total_after_deductions','milage_hours_during_month','milage_hours_per_liter','fuel_expense'));
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
        if(Auth::user()->can($this->permission))
        {
          try{
                $id = decrypt($id);
                $fuel_consumption = Fuel_consumption::find($id);
                $files = json_decode($fuel_consumption->file_attachments);
                $suppliers = Suppliers::where('status',1)->where('suppliers_types_id','2')->pluck('name','id')->toArray();
                $projects = Project::where('status',1)->pluck('name','id')->toArray();
                $tax_bodies = Taxation_bodies::pluck('name','id')->toArray();
                return view($this->filePath.'.edit',compact('suppliers','projects','tax_bodies','fuel_consumption','files'));
          }
          catch(Exception $e){
                Session::flash('error','Fuel Consumption not found!');
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

        if(Auth::user()->can($this->permission))
        {
            try
            {
                $id = decrypt($id);
                $fuel_consumption = Fuel_consumption::find($id);

                $input['title_po_number'] = $request->title_po_number;
                $input['project_id'] = $request->project_id;
                $input['date_of_entry'] = $request->date_of_entry;
                $input['entry_person'] = $request->entry_person;
                $input['driver_person'] = $request->driver_person;
                $input['fueling_item_id'] = $request->fueling_item_id;
                $input['fuel_item_code'] = $request->fuel_item_code;
                $input['supplier_id'] = $request->supplier_id;
                $input['consumption_month'] = $request->consumption_month;
                $input['quantity_in_liter'] = $request->quantity_in_liter;
                $input['amount_with_sale_tax'] = $request->amount_with_sale_tax;
                $input['rate_fuel_per_liter'] = $request->rate_fuel_per_liter;
                $input['milage_hours'] = $request->milage_hours;
                $input['oil_filter_due_date'] = $request->oil_filter_due_date;
                $input['tax_body_id'] = $request->tax_body_id;
                $input['taxation_month'] = $request->taxation_month;
                $input['tax_body_percentage'] = $request->tax_body_percentage;
                $input['comments'] = $request->comments;
                $input['sales_tax_withheld_at_source_per'] = $request->sales_tax_withheld_at_source_per;
                $input['supplier_withheld_tax_1_deduction_per'] = $request->supplier_withheld_tax_1_deduction_per;
                $input['item_type'] = $request->item_type;
                
                $images = json_decode($fuel_consumption->file_attachments);
              
                $remove_images = [];
                $new_images    = [];

            
                if(isset($request->remove_images)){
                    $remove_images = explode(',',$request->remove_images);
                    foreach($remove_images as $img)
                    {
                        FileUploader::RemoveFile($img,"Fuel_consumption");
                    }
                }

                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,"fuel_consumption","Fuel_consumption");
                        array_push($new_images,$filename);
                    }
                }

                if($fuel_consumption->file_attachments !=null){
                    foreach($images as $img)
                    {
                        if (!in_array($img,$remove_images)) {
                            array_push($new_images,$img);
                        }
                    }
                }
              
              $input['file_attachments'] = $new_images;

              $fuel_consumption->update($input);

            //   updating supplier ledger

            // $supplier_ledger = SupplierLedger::edit_supplier_tax(
            //     $fuel_consumption->supplier_id,
            //     $fuel_consumption->id,
            //     "payment_in",
            //     'fuel_consumption',
            //     'Supplier withheld Tax 1 Deduction',
            //     $fuel_consumption->supplier_withheld_tax_1_deduction_per
            // );

    
            Session::flash('updated', 'Fuel Consumption updated successfully!');
            return redirect()->route('fuelconsumption.index');
            
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
    public function destroy(request $request,$id)
    {
        $id = $request->id;
        if(Auth::user()->can($this->permission))
        {
           try {    
                $fuel_consumption = Fuel_consumption::find($id);
            
                if($fuel_consumption)
                {
                    $fuel_consumption->delete();
                    return response()->json(['success' => true, 'message' => 'Fuel Consumption deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Fuel Consumption deletion failed'], 422);
                }
               
           }
           catch(Exception $e){
                Session::flash('error', 'Fuel Consumption not Deleted');
                return redirect()->back();
           }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }


    public function get_project_fuel_items(Request $request){
        $project_id = $request->id;
        $fuel_items = Fuel_items::where('project_id',$project_id)->select('item_code','item_name','id','current_balance_item','monthly_limit')->get();
        $assets = Damcon_asssets::where('project_id',$project_id)->select('id','asset_item_id','registration_no','asset_maintenance_duration')->get();
        $customer_assets = CustomerAssetsManagement::where('project_id',$project_id)->select('id','asset_item_id','registration_number')->get();
        $rental_items = RentalItemsManagement::select('id','rental_id','rental_name')->with('supplier_rental')->get();
        if($fuel_items)
        {
            return response()->json(['success' => true, 'message' => "FuelItems Found!",'fuel_items' => $fuel_items,'assets' => $assets,'customer_assets' => $customer_assets,'rental_items' => $rental_items], 200);
        }
        else{
            return response()->json(['error' => true, 'message' =>"Fuel Item not found",'fuel_items' => NULL,'assets' => NULL], 404);

        }
    }


    public function get_Item_previous_milage(request $r)
    {
       
        // $fuel_milage = Fuel_consumption::where('fueling_item_id',$r->id)->select('milage_hours')->latest()->first();

        // if($fuel_milage != '')
        // {
        //     $milage = $fuel_milage->milage_hours;
        //     return response()->json(['success' => true,'fuel_milage' => $milage], 200);
        // }
        // else{

            $item_type = $r->item_type;

            if($item_type == "damcon")
            {
                $fuel_milage = Damcon_asssets::where('id',$r->id)->select('asset_total_km_hr')->first();
                $milage = $fuel_milage->asset_total_km_hr;
            }
            else if($item_type == "customer")
            {
                $fuel_milage = CustomerAssetsManagement::where('id',$r->id)->select('milage')->first();
                $milage = $fuel_milage->milage;

            }
            else if($item_type == "rentalitems")
            {
                $fuel_milage = RentalItemsManagement::where('id',$r->id)->select('current_milage')->first();
                $milage = $fuel_milage->current_milage;

            }


            return response()->json(['success' => true,'fuel_milage' => $milage], 200);

       // }

    }
}
