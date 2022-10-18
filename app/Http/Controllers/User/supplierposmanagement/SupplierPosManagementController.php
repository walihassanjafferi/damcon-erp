<?php

namespace App\Http\Controllers\User\supplierposmanagement;

use App\Models\SupplierPosManagement;
use App\Models\SupplierPosManagementDetails;
use App\Models\Suppliers;
use App\Models\Taxation_bodies;
use App\Models\Project_items_inventory;
use App\Traits\FileAttachmentsTrait as FileUploader;
use App\Models\Project_items_inventory_updates;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use DataTables;
use DB;
use App\Traits\SupplierTaxledgerTrait as SupplierLedger;
use App\Traits\ProjectItemsInventoryTraitUpdates as Inventory_update;


class SupplierPosManagementController extends Controller
{

    private $path  = 'user.purchaseordersmanagement.supplier_pos_management';
    private $authR = 'supplier_purchase_order';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can($this->authR))
        {
            return view($this->path.'.index');
        }
        else{
            return redirect()->route('not_authorized');
        }
    }


    public function getSupplierOrders(Request $request)
    {
        if(Auth::user()->can($this->authR))
        {
            if ($request->ajax()) {
                $data = SupplierPosManagement::Join('suppliers AS S','supplier_pos_management.supplier_id','S.id')
                    ->orderby('id','desc')
                    ->get(['supplier_pos_management.*','S.name AS supplier_name']);

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '<a href="'.route('supplierspos.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                                      <a href="'.route('supplierspos.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;
                                      <a  onclick="deleteOrder('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>';
                        return $actionBtn;
                    })->addColumn('checkbox',function($row){
                        $checkBtn = '<input type="checkbox" class="order_check"  value="'.$row->id.'">';
                        return $checkBtn;
                    })
                    ->addColumn('issue_date',function($row){
                        $checkBtn = date('d-M-Y',strtotime($row->issue_date));
                        return $checkBtn;
                    })
                    ->addColumn('issue_date1',function($row){
                        $checkBtn = $row->issue_date;
                        return $checkBtn;
                    })
                    ->rawColumns(['action','checkbox','issue_date','issue_date1'])
                    ->make(true);
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
        if(Auth::user()->can($this->authR))
        {
            $supplies = Suppliers::where('suppliers_types_id',1)->pluck('name','id')->toArray();
            $taxbodys = Taxation_bodies::pluck('name','id')->toArray();
            return view($this->path.'.create',compact('supplies','taxbodys'));
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
    public function store(Request $r)
    {

        if(Auth::user()->can($this->authR))
        {
        
            try {   

                DB::beginTransaction();

                // checking unique supplier orderno
                $supplier_po = SupplierPosManagement::where('purchase_od_number',$r->purchase_od_number)->count();
                if($supplier_po)
                {
                    Session::flash('error',"Purchase Order Number already exists!");
                    return redirect()->back()->withInput();
                }

                $supplier_pos                             = new SupplierPosManagement();
                $supplier_pos->user_id                    = Auth::id();
                $supplier_pos->purchase_od_number         = $r->purchase_od_number;
                $supplier_pos->grm_number                 = $r->grm_number;
                $supplier_pos->type                       = $r->type;
                $supplier_pos->supplier_id                = $r->supplier_id;
                $supplier_pos->customer_optional_number   = $r->customer_optional_number ?? null;
                $supplier_pos->requesting_person          = $r->requesting_person;
                $supplier_pos->issue_date                 = $r->issue_date;
                $supplier_pos->items_delivery_date        = $r->items_delivery_date;
                $supplier_pos->payment_terms              = $r->payment_terms;
                $supplier_pos->pr_number                  = $r->pr_number;
                $supplier_pos->tax_body_id                = $r->tax_body_id;
                $supplier_pos->taxation_month             = $r->taxation_month;
                $supplier_pos->tax_body_percentage        = $r->tax_body_percentage;
                $supplier_pos->sales_tax_wh               = $r->sales_tax_wh;
                $supplier_pos->tax_deduction_1            = $r->tax_deduction_1;
                $supplier_pos->tax_deduction_2            = $r->tax_deduction_2;
                $supplier_pos->comments                   = $r->comments;


                $image_names=[];

                //Upload Files
                if($r->hasfile('document_file'))
                {
                    foreach($r->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,"supplier_pos","S_POS");
                        array_push($image_names,$filename);
                    }
                    $supplier_pos->document_file  = json_encode($image_names);
                }

                //Save Files
                if($supplier_pos->save())
                {
                    //saving items
                    $items_name     = $r->item_name;
                    $items_quantity = $r->item_quantity;
                    $item_cost      = $r->item_cost;

                    foreach($items_name as $index=>$item)
                    {
                        // find item in DB
                        $item_inventory = Project_items_inventory::find($items_name[$index]);
                        $supplier_pos_details                                 = new SupplierPosManagementDetails();
                        $supplier_pos_details->inventory_item_id              = $items_name[$index];
                        $supplier_pos_details->item                           = $item_inventory->item_name;
                        $supplier_pos_details->qty                            = $items_quantity[$index];
                        $supplier_pos_details->cost                           = $item_cost[$index];
                        $supplier_pos_details->supplier_pos_id                = $supplier_pos->id;
                        $supplier_pos_details->save();

                        // updating inventory now

                        $inventoryStockIn  = Project_items_inventory_updates::where([['stock_update', 'stock in'], ['project_items_id',$items_name[$index]]])->sum('updated_stock');
                        $inventoryStockOut = Project_items_inventory_updates::where([['stock_update', 'stock out'], ['project_items_id',$items_name[$index]]])->sum('updated_stock');


                        $qtyBalance = $inventoryStockIn - $inventoryStockOut;

                        $totalCost  = ($item_inventory->average_unit_cost * $qtyBalance) + ($item_cost[$index]*$items_quantity[$index]);
                        $totalQty   = $qtyBalance +  $items_quantity[$index];
                        $avgUnitCost = $totalCost / $totalQty;

                
                        // updating inventory item average unit cost
                        $item_inventory->average_unit_cost = $avgUnitCost;
                        $item_inventory->save();

                        $item_record = Project_items_inventory_updates::where('project_items_id',$item_inventory->id)->orderBy('id', 'DESC')->first();

                        // now update trait function inventory
                        Inventory_update::inventoryUpdate(
                            $item_inventory->id, //project id
                            Carbon::now(), //update date
                            "stock in", //stock udpate
                            $item_record->current_closing_stock ?? 0, //opening stock
                            $item_record->current_closing_stock_cost ?? 0,  //opening stock cost
                            $items_quantity[$index], //quantity type
                            $items_quantity[$index], //updated stock   $stockQty
                            ($item_cost[$index]*$items_quantity[$index]),  //updated stock cost
                            $avgUnitCost, // cost per unit
                            $totalQty, //current closing stock 
                            $totalCost , //current closing stock cost
                        );

                    }
                    // saving items

                
                    /**calculate formulas**/
                    $total_items_cost = []; $total_items_quantity = [];$items_cost = array();


                    foreach( $supplier_pos->supplier_pos_items as $item)
                    {
                        array_push($items_cost,$item->cost);
                        array_push($total_items_quantity,$item->qty);
                    }

        
                    foreach ($items_cost as $index=>$item)
                    {
                        $total = floatval($item) * floatval($items_quantity[$index]);
                        array_push($total_items_cost,$total);
                    }

                    //sub amount total
                    $sub_total_amount = array_sum($total_items_cost);

                    $total_items_quantity = array_sum($total_items_quantity);
                    // calculating tax amount
                    $tax_amount =  $sub_total_amount * ($supplier_pos->tax_body_percentage/100);
                
                    // total amount
                    $total_amount = $sub_total_amount + $tax_amount;
                    // Sales Tax WH at Source
                    $sales_tax_wh_at_src =  $tax_amount * ($supplier_pos->sales_tax_wh/100);
                    //Supplier WH Tax 1 
                    $supplier_wh_tax_1 = $total_amount * ($supplier_pos->tax_deduction_1/100);
                    //Supplier WH Tax 2 
                    $supplier_wh_tax_2 = $total_amount * ($supplier_pos->tax_deduction_2/100);
                    // total after deduction
                    $total_after_deduction = $total_amount - $sales_tax_wh_at_src - $supplier_wh_tax_1 - $supplier_wh_tax_2;
                    // after tax item amount
                    $after_tax_item_cost = $total_amount/$total_items_quantity;

                    /*saving formulas */
                    $supplier_pos->sub_total_amount = $sub_total_amount;
                    $supplier_pos->tax_amount = $tax_amount;
                    $supplier_pos->total_amount = $total_amount;
                    $supplier_pos->sales_tax_wh_at_src = $sales_tax_wh_at_src;
                    $supplier_pos->supplier_wh_tax_1 = $supplier_wh_tax_1;
                    $supplier_pos->supplier_wh_tax_2 = $supplier_wh_tax_2;
                    $supplier_pos->total_after_deduction = $total_after_deduction;
                    $supplier_pos->after_tax_item_cost = $after_tax_item_cost;

                    $supplier_pos->save();

                    // add amount to supplier ledger
                    ##Supplier withheld Tax 1
                    $supplier_ledger = SupplierLedger::add_supplier_tax(
                        $supplier_pos->supplier_id,
                        $supplier_pos->id,
                        "payment_in",
                        'Supplier POS',
                        'Total Amount',
                        $total_amount
                    );

                    ##adding supplier payables
                    SupplierLedger::add_supplier_purchase_pay(
                        $supplier_pos->purchase_od_number,
                        $supplier_pos->supplier_id, //supplier_ids
                        $total_after_deduction, //purchase amount
                        0 // payment amount
                    );
                    
                    
                    /*saving formulas */
                    DB::commit();
    
                    Session::flash('created', 'Supplier Purchase Order Added Successfully');
                
                    return redirect()->route('supplierspos.index');
                }
                else{

                    Session::flash('error', 'Error adding Supplier Purchase Order');
                    return redirect()->back()->withInput();
                }

            }catch(Exception $e){
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
        if(Auth::user()->can($this->authR))
        {
            $id                      = decrypt($id);
            $supplier_purchase_order = SupplierPosManagement::find($id);
            $supplier_items          = SupplierPosManagementDetails::where('supplier_pos_id',$supplier_purchase_order->id)->get();
            return view($this->path.'.view',compact('supplier_purchase_order','supplier_items'));
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
        if(Auth::user()->can($this->authR))
        {
            $id                      = decrypt($id);
            $supplies                = Suppliers::where('suppliers_types_id',1)->pluck('name','id')->toArray();
            $taxbodys                = Taxation_bodies::pluck('name','id')->toArray();
            $supplier_purchase_order = SupplierPosManagement::find($id);
            $supplier_items          = SupplierPosManagementDetails::where('supplier_pos_id',$supplier_purchase_order->id)->get();
            return view($this->path.'.edit',compact('supplies','taxbodys','supplier_purchase_order','supplier_items'));
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
    public function update(Request $r, $id)
    {
        if(Auth::user()->can($this->authR))
        {
            DB::beginTransaction();
            try {
                $id  = decrypt($id);
                $supplier_pos                             = SupplierPosManagement::find($id);
                $supplier_pos->purchase_od_number         = $r->purchase_od_number;
                $supplier_pos->grm_number                 = $r->grm_number;
                $supplier_pos->type                       = $r->type;
                $supplier_pos->supplier_id                = $r->supplier_id;
                $supplier_pos->customer_optional_number   = $r->customer_optional_number ?? null;
                $supplier_pos->requesting_person          = $r->requesting_person;
                $supplier_pos->issue_date                 = $r->issue_date;
                $supplier_pos->items_delivery_date        = $r->items_delivery_date;
                $supplier_pos->payment_terms              = $r->payment_terms;
                $supplier_pos->pr_number                  = $r->pr_number;
                $supplier_pos->tax_body_id                = $r->tax_body_id;
                $supplier_pos->taxation_month             = $r->taxation_month;
                $supplier_pos->tax_body_percentage        = $r->tax_body_percentage;
                $supplier_pos->sales_tax_wh               = $r->sales_tax_wh;
                $supplier_pos->tax_deduction_1            = $r->tax_deduction_1;
                $supplier_pos->tax_deduction_2            = $r->tax_deduction_2;
                $supplier_pos->comments                   = $r->comments;


                $images = json_decode($supplier_pos->document_file);

                $remove_images = [];
                $new_images    = [];

                if(isset($r->remove_images)){
                    $remove_images = explode(',',$r->remove_images);
                    foreach($remove_images as $img)
                    {
                        FileUploader::RemoveFile($img,"supplier_pos");
                    }
                }

                if($r->hasfile('document_file'))
                {
                    foreach($r->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,"supplier_pos","S_POS");
                        array_push($new_images,$filename);
                    }
                }

                if($supplier_pos->document_file !=null){
                    foreach($images as $img)
                    {
                        if (!in_array($img,$remove_images)) {
                            array_push($new_images,$img);
                        }
                    }
                }

                $supplier_pos->document_file = $new_images;

                //Save Files

                if($supplier_pos->update())
                {
                    // //Delete Items
                    // SupplierPosManagementDetails::where('supplier_pos_id',$id)->delete();

                    // //saving items
                    // $items_name     = $r->item_name;
                    // $items_quantity = $r->item_quantity;
                    // $item_cost      = $r->item_cost;

                    // foreach($items_name as $index=>$item)
                    // {
                    //     $supplier_pos_details                                 = new SupplierPosManagementDetails();
                    //     $supplier_pos_details->item                           = $items_name[$index];
                    //     $supplier_pos_details->qty                            = $items_quantity[$index];
                    //     $supplier_pos_details->cost                           = $item_cost[$index];
                    //     $supplier_pos_details->supplier_pos_id                = $supplier_pos->id;
                    //     $supplier_pos_details->save();
                    // }
                    // // saving items

                    
                    // /**calculate formulas**/
                    // $total_items_cost = []; $total_items_quantity = [];$items_cost = array();


                    // foreach( $supplier_pos->supplier_pos_items as $item)
                    // {
                    //     array_push($items_cost,$item->cost);
                    //     array_push($total_items_quantity,$item->qty);
                    // }

        
                    // foreach ($items_cost as $index=>$item)
                    // {
                    //     $total = floatval($item) * floatval($items_quantity[$index]);
                    //     array_push($total_items_cost,$total);
                    // }

                    // //sub amount total
                    // $sub_total_amount = array_sum($total_items_cost);

                    // $total_items_quantity = array_sum($total_items_quantity);
                    // // calculating tax amount
                    // $tax_amount =  $sub_total_amount * ($supplier_pos->tax_body_percentage/100);
                
                    // // total amount
                    // $total_amount = $sub_total_amount + $tax_amount;
                    // // Sales Tax WH at Source
                    // $sales_tax_wh_at_src =  $tax_amount * ($supplier_pos->sales_tax_wh/100);
                    // //Supplier WH Tax 1 
                    // $supplier_wh_tax_1 = $total_amount * ($supplier_pos->tax_deduction_1/100);
                    // //Supplier WH Tax 2 
                    // $supplier_wh_tax_2 = $total_amount * ($supplier_pos->tax_deduction_2/100);
                    // // total after deduction
                    // $total_after_deduction = $total_amount - $sales_tax_wh_at_src - $supplier_wh_tax_1 - $supplier_wh_tax_2;
                    // // after tax item amount
                    // $after_tax_item_cost = $total_amount/$total_items_quantity;

                    // /*saving formulas */
                    // $supplier_pos->sub_total_amount = $sub_total_amount;
                    // $supplier_pos->tax_amount = $tax_amount;
                    // $supplier_pos->total_amount = $total_amount;
                    // $supplier_pos->sales_tax_wh_at_src = $sales_tax_wh_at_src;
                    // $supplier_pos->supplier_wh_tax_1 = $supplier_wh_tax_1;
                    // $supplier_pos->supplier_wh_tax_2 = $supplier_wh_tax_2;
                    // $supplier_pos->total_after_deduction = $total_after_deduction;
                    // $supplier_pos->after_tax_item_cost = $after_tax_item_cost;



                    // $supplier_pos->update();


                    DB::commit();

                    Session::flash('created', 'Supplier Purchase Order Updated Successfully');
                    return redirect()->back()->withInput();
                    return redirect()->route('supplierspos.index');
                }
                else{

                    Session::flash('error', 'Error updating Supplier Purchase Order');
                    return redirect()->back()->withInput();
                }

            }catch(Exception $e){
                DB::rollback();
                Session::flash('error', 'Error updating Supplier Purchase Order');
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
    public function destroy($id, Request $request)
    {
        if(Auth::user()->can($this->authR))
        {
            try {
                $id = $request->id;
                $supplierpos = SupplierPosManagement::find($id);
                if($supplierpos)
                {
                    if($supplierpos->document_file !=null){
                        foreach(json_decode($supplierpos->document_file) as $img)
                        {
                            FileUploader::RemoveFile($img,"supplier_pos");
                        }
                    }
                    //Delete Items
                    SupplierPosManagementDetails::where('supplier_pos_id',$id)->delete();
                    $supplierpos->delete();
                    return response()->json(['success' => true, 'message' => 'Supplier Purchase Order deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Customer Purchase Order deletion failed'], 422);
                }
            }
            catch(Exception $e){
                Session::flash('error', 'Supplier Purchase Order not Deleted');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }


    // Delete Bulk Orders
    public function destroy_bulk(Request $r){
        if(Auth::user()->can($this->authR))
        {
            try {
                $orderList = $r->order_list;
                SupplierPosManagement::find($orderList)->each(function ($supplierpos) {
                    if($supplierpos)
                    {
                        if($supplierpos->document_file !=null){
                            foreach(json_decode($supplierpos->document_file) as $img)
                            {
                                FileUploader::RemoveFile($img,"customer_pos");
                            }
                        }
                        //Delete Items
                        SupplierPosManagementDetails::where('supplier_pos_id',$supplierpos->id)->delete();
                        $supplierpos->delete();
                    }
                    else{
                        return response()->json(['error' => true, 'message' => 'Supplier Purchase Order deletion failed'], 422);
                    }
                });
                return response()->json(['success' => true, 'message' => 'Supplier Purchase Order deleted Successfully'], 200);

            }catch(Exception $e){
                Session::flash('error', 'Supplier Purchase Order not Deleted');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }


    public function get_Supplier_items_po(Request $request){

        $supplier_id = $request->supplier_id;
        // $assets = Damcon_asssets::where('supplier_id',$request->supplier_id)->get();

        $supplier_items = DB::table('project_items_inventory_suppliers')->where('supplier_id',$supplier_id)->pluck('project_items_id');
        $items = Project_items_inventory::whereIn('id',$supplier_items)->with('category','main_category','subCategory','subsubCategory')->get();
        return response()->json(['success' => true, 'items' =>  $items], 200);

    }


}
