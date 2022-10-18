<?php

namespace App\Http\Controllers\User\invoiceandincome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Taxation_bodies;
use App\Models\CustomerPosManagement;
use App\Models\Customer;
use App\Models\Project;
use App\Models\customer_invoice_management;
use App\Models\Customer_Invoice_Items;
use App\Models\Customer_PO_balance_logs;
use App\Traits\FileAttachmentsTrait as FileUploader;
use App\Traits\TaxBodyledgerTrait as TaxBodyLedger;
use App\Traits\SupplierTaxledgerTrait as SupplierLedger;
use DataTables;
use Auth;
use Session;
use Exception;
use DB;

class CustomerInvoiceManagementController extends Controller
{
    private $path    = 'user.invoicingincomemanagement.customerinvoicemanagement';
    private $authR   = 'invoice_income_management';
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        if(Auth::user()->can($this->authR))
        {
            $tax_bodies = Taxation_bodies::pluck('name','id')->toArray();
            $customer_po = CustomerPosManagement::with('toProject')->get();
            $customer = Customer::where('status',1)->get();
            $projects = Project::where('status',1)->pluck('name','id')->toArray();

            return view($this->path.'.create',compact('tax_bodies','customer_po','customer','projects'));
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
     
        if(Auth::user()->can($this->authR))
        {
            DB::beginTransaction();
            try{

                $invoice_number = customer_invoice_management::where('invoice_number',$request->invoice_number)->first();

                if($invoice_number)
                {
                    Session::flash('error',"Duplicate invoice number!");
                    return redirect()->back()->withInput();
                }

                $customer_invoice_management = new customer_invoice_management();
                $customer_invoice_management->invoice_number = $request->invoice_number;
                $customer_invoice_management->title = $request->title;
                $customer_invoice_management->date_of_invoicing = $request->date_of_invoicing;
                $customer_invoice_management->detail_of_invoice = $request->detail_of_invoice;
                $customer_invoice_management->customer_po_id = $request->customer_po_id;
                $customer_invoice_management->project_id = $request->project_id;
                $customer_invoice_management->po_balance = $request->po_balance;
                $customer_invoice_management->customer_name = $request->customer_name;
                $customer_invoice_management->customer_id = $request->customer_id;
                $customer_invoice_management->invoice_month = $request->invoice_month;
                $customer_invoice_management->region = $request->region;
                $customer_invoice_management->tax_id = $request->tax_id;
                $customer_invoice_management->tax_body_description = $request->tax_body_description;
                $customer_invoice_management->taxation_month = $request->taxation_month;
                $customer_invoice_management->tax_body_percentage = $request->tax_body_percentage;
                $customer_invoice_management->tax_type_comments = $request->tax_type_comments;
                $customer_invoice_management->penality_deduction_amount = $request->penality_deduction_amount;
                $customer_invoice_management->penality_deduction_comment = $request->penality_deduction_comment;
                $customer_invoice_management->sales_tax_source_percentage = $request->sales_tax_source_percentage;
                $customer_invoice_management->after_tax_deduction = $request->after_tax_deduction;
                $customer_invoice_management->after_tax_deduction_comments = $request->after_tax_deduction_comments;
                $customer_invoice_management->withhold_tax1_percentage = $request->withhold_tax1_percentage;
                $customer_invoice_management->withhold_tax2_percentage = $request->withhold_tax2_percentage;
                $customer_invoice_management->comments = $request->comments;
                $customer_invoice_management->type = $request->type;

    
                // saving images
    
                $new_images = [];
                    
                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,'customerInvoice','customer_invoice');
                        array_push($new_images,$filename);
                    }
                }
              
                $customer_invoice_management->document_file = json_encode($new_images);
    
                if($customer_invoice_management->save())
                {
                    ##customer invoice items

                    $items_name = $request->item_name;
                    $items_quantity = $request->item_quantity;
                    $item_cost = $request->item_cost;

                    foreach($items_name as $index=>$item)
                    {

                        $input_items['item_name'] = $item;
                        $input_items['item_qunatity'] = $items_quantity[$index];
                        $input_items['item_cost'] = $item_cost[$index];
                        $input_items['customer_invoice_management_id'] = $customer_invoice_management->id;
                        $items = Customer_Invoice_Items::firstOrCreate($input_items);
                    }
                    // saving items

                    ###Saving formulas 
                    $cvm = customer_invoice_management::find($customer_invoice_management->id);
                    $items_cost = array();
                    $items_quantity  = array();
                    $total_items_cost = array();
                    // calculatigng items cost
                    foreach( $cvm->items as $item)
                    {
                        array_push($items_cost,$item->item_cost);
                        array_push($items_quantity,$item->item_qunatity);
                    }
        
                    
                    foreach ($items_cost as $index=>$item)
                    {
                        $total = floatval($item) * floatval($items_quantity[$index]);
                        array_push($total_items_cost,$total);
                    }
        
                   
                    $sub_total_amount = array_sum($total_items_cost);
                   
                    ##before tax total
                    $before_tax_total = floatval($sub_total_amount) - floatval($cvm->penality_deduction_amount);
                  
                    ##tax body amount
        
                    $tax_amount = $before_tax_total * floatval($cvm->tax_body_percentage / 100);
                
                    ##total amount
                    $total_amount = $before_tax_total + $tax_amount;
        
                    ##sales tax  Sales Tax WH at Source
                    $sales_tax_wh_at_source =  $tax_amount * floatval($cvm->sales_tax_source_percentage / 100);
                 
                    ##After Tax Total
                    $after_tax_total  = $total_amount - floatval($cvm->after_tax_deduction);
        
                    ##withholding tax 1
                    $wh_tax_1 = $after_tax_total * floatval($cvm->withhold_tax1_percentage / 100);
        
                    ##withholding tax 2
                    $wh_tax_2 =  $total_amount * floatval($cvm->withhold_tax2_percentage / 100);
                    
                    ##total after deductions
                    $total_after_deductions = $total_amount - $sales_tax_wh_at_source - $wh_tax_1 - $wh_tax_2;
        
                    ##net income
                    $net_income =  $before_tax_total - $wh_tax_1 -  $wh_tax_2;

                    $cvm->sub_total_amount = $sub_total_amount;

                    $cvm->before_tax_total = $before_tax_total;

                    $cvm->tax_amount = $tax_amount;

                    $cvm->total_amount = $total_amount;

                    $cvm->sales_tax_wh_at_src =  $sales_tax_wh_at_source;

                    $cvm->after_tax_total = $after_tax_total;

                    $cvm->supplier_wh_tax_1 =  $wh_tax_1;

                    $cvm->supplier_wh_tax_2 =  $wh_tax_2;

                    $cvm->net_income =  $net_income;
 
                    $cvm->total_after_deductions = $total_after_deductions;

                    $cvm->save();

                    ##tax body ledgers
                    TaxBodyLedger::add_taxbody_ledger(
                        $customer_invoice_management->tax_id,
                        $customer_invoice_management->id,
                        "payment_in",
                        'customer_invoice_managements',
                        'Tax Body Amount',
                        $tax_amount
                    );
                    ##tax body ledgers

                    ##supplier tax ledger##
                    
                    // SupplierLedger::add_supplier_tax(
                    //     $assets_po->supplier_id,
                    //     $assets_po->id,
                    //     "payment_in",
                    //     'asset_pos',
                    //     'Supplier wh tax 1',
                    //     $supplier_wh_tax_1
                    // );

                    // SupplierLedger::add_supplier_tax(
                    //     $assets_po->supplier_id,
                    //     $assets_po->id,
                    //     "payment_in",
                    //     'asset_pos',
                    //     'Supplier wh tax 2',
                    //     $supplier_wh_tax_2
                    // );


                    ##supplier tax ledger##

                
                    ###saving formulas

                    ###saving PO BALANCE LOGS
                    $cvm->refresh();
                    $customer_invoice_management->refresh();
                    $customer_PO_balance_logs_pre = Customer_PO_balance_logs::where('customer_po_id',$customer_invoice_management->customer_po_id)->orderBy('id','desc')->first();

                    if($customer_PO_balance_logs_pre!=NULL)
                    {
                        $customer_PO_balance_logs = new Customer_PO_balance_logs();
                        $customer_PO_balance_logs->customer_po_id = $customer_invoice_management->customer_po_id;
                        $customer_PO_balance_logs->previous_po_balance = $customer_PO_balance_logs_pre->new_po_balance;
                        $customer_PO_balance_logs->new_po_balance = $customer_PO_balance_logs_pre->new_po_balance - $cvm->total_after_deductions;
                        $customer_PO_balance_logs->invoice_amount = $cvm->total_after_deductions;
                        $customer_PO_balance_logs->customer_invoice_id = $customer_invoice_management->id;
                        $customer_PO_balance_logs->save();
                    }
                    else{
                       
                        $customer_PO_balance_logs = new Customer_PO_balance_logs();
                        $customer_PO_balance_logs->customer_po_id = $customer_invoice_management->customer_po_id;
                        $customer_PO_balance_logs->previous_po_balance = $customer_invoice_management->po_balance;
                        $customer_PO_balance_logs->new_po_balance = $customer_invoice_management->po_balance - $cvm->total_after_deductions;
                        $customer_PO_balance_logs->invoice_amount = $cvm->total_after_deductions;
                        $customer_PO_balance_logs->customer_invoice_id = $customer_invoice_management->id;
                        $customer_PO_balance_logs->save();
                    }

                    ###saving PO BALANCE LOGS


                    DB::commit();

                    Session::flash('created', 'Customer Invoice Added Successfully');

                    return redirect()->route('customerinvoice.index');


                }
                else{
                    Session::flash('error','Error Adding Customer Invoice!');
                    return redirect()->back()->withInput();
                }
            }
            catch(Exception $e)
            {
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
        try{
            $id = decrypt($id);
           
            $cvm = customer_invoice_management::find($id);

            $items_cost = array();
            $items_quantity  = array();
            $total_items_cost = array();
            // calculatigng items cost
            foreach( $cvm->items as $item)
            {
                array_push($items_cost,$item->item_cost);
                array_push($items_quantity,$item->item_qunatity);
            }

            
            foreach ($items_cost as $index=>$item)
            {
                $total = floatval($item) * floatval($items_quantity[$index]);
                array_push($total_items_cost,$total);
            }

           
            $sub_total_amount = array_sum($total_items_cost);
           
            ##before tax total
            $before_tax_total = floatval($sub_total_amount) - floatval($cvm->penality_deduction_amount);
          
            ##tax body amount

            $tax_amount = $before_tax_total * floatval($cvm->tax_body_percentage / 100);
        
            ##total amount
            $total_amount = $before_tax_total + $tax_amount;

            ##sales tax  Sales Tax WH at Source
            $sales_tax_wh_at_source =  $tax_amount * floatval($cvm->sales_tax_source_percentage / 100);
         
            ##After Tax Total
            $after_tax_total  = $total_amount - floatval($cvm->after_tax_deduction);

            ##withholding tax 1
            $wh_tax_1 = $after_tax_total * floatval($cvm->withhold_tax1_percentage / 100);

            ##withholding tax 2
            $wh_tax_2 =  $total_amount * floatval($cvm->withhold_tax2_percentage / 100);
            
            ##total after deductions
            $total_after_deductions = $total_amount - $sales_tax_wh_at_source - $wh_tax_1 - $wh_tax_2;

            ##net income
            $net_income =  $before_tax_total - $wh_tax_1 -  $wh_tax_2;

            $net_income =  $before_tax_total - $wh_tax_1 -  $wh_tax_2;
           
           // dd('idr');
            return view($this->path.'.view',compact('cvm','sub_total_amount','before_tax_total','tax_amount','total_amount','sales_tax_wh_at_source','after_tax_total','wh_tax_1','wh_tax_2','total_after_deductions','net_income'));

        }
        catch(Exception $e)
        {
            Session::flash('error',$e->getMessage());
            return redirect()->back();
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
            $id = decrypt($id);
            $tax_bodies = Taxation_bodies::pluck('name','id')->toArray();
            $customer_po = CustomerPosManagement::with('toProject')->get();
            $customer = Customer::where('status',1)->get();
            $cvm = customer_invoice_management::find($id);
            $customer_invoice_items = Customer_Invoice_Items::where('customer_invoice_management_id',$id)->get();
           
            return view($this->path.'.edit',compact('tax_bodies','customer_po','customer','cvm','customer_invoice_items'));
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
       /// DD($request->all());
        if(Auth::user()->can($this->authR))
        {
            try{
                $id = decrypt($id);
                $customer_invoice_management =  customer_invoice_management::find($id);
                $customer_invoice_management->invoice_number = $request->invoice_number;
                $customer_invoice_management->title = $request->title;
                $customer_invoice_management->date_of_invoicing = $request->date_of_invoicing;
                $customer_invoice_management->detail_of_invoice = $request->detail_of_invoice;
                $customer_invoice_management->project_id = $request->project_id;
                $customer_invoice_management->customer_po_id = $request->customer_po_id;
                $customer_invoice_management->po_balance = $request->po_balance;
                $customer_invoice_management->customer_name = $request->customer_name;
                $customer_invoice_management->customer_id = $request->customer_id;
                $customer_invoice_management->invoice_month = $request->invoice_month;
                $customer_invoice_management->region = $request->region;
                $customer_invoice_management->tax_id = $request->tax_id;
                $customer_invoice_management->tax_body_description = $request->tax_body_description;
                $customer_invoice_management->taxation_month = $request->taxation_month;
                $customer_invoice_management->tax_body_percentage = $request->tax_body_percentage;
                $customer_invoice_management->tax_type_comments = $request->tax_type_comments;
                $customer_invoice_management->penality_deduction_amount = $request->penality_deduction_amount;
                $customer_invoice_management->penality_deduction_comment = $request->penality_deduction_comment;
                $customer_invoice_management->sales_tax_source_percentage = $request->sales_tax_source_percentage;
                $customer_invoice_management->after_tax_deduction = $request->after_tax_deduction;
                $customer_invoice_management->after_tax_deduction_comments = $request->after_tax_deduction_comments;
                $customer_invoice_management->withhold_tax1_percentage = $request->withhold_tax1_percentage;
                $customer_invoice_management->withhold_tax2_percentage = $request->withhold_tax2_percentage;
                $customer_invoice_management->comments = $request->comments;
                $customer_invoice_management->type = $request->type;

              //  $customer_invoice_management->invoice_status 
    
                ##updating images
            
                 $images  = json_decode($customer_invoice_management->document_file);
    
                 $remove_images = [];
                 $new_images    = [];
     
     
                 if(isset($request->remove_images)){
                     $remove_images = explode(',',$request->remove_images);
                     foreach($remove_images as $img)
                     {
                         FileUploader::RemoveFile($img,'customerInvoice');
                     }
                 }
     
                 if($request->hasfile('document_file'))
                 {
                     foreach($request->file('document_file') as $image)
                     {
                         $filename = FileUploader::uploadFile($image,'customerInvoice','customer_invoice');
                         array_push($new_images,$filename);
                     }
                 }
     
                 if($customer_invoice_management->document_file !=null){
                     foreach($images as $img)
                     {
                         if (!in_array($img,$remove_images)) {
                             array_push($new_images,$img);
                         }
                     }
                 }
     
                
                 $customer_invoice_management->document_file = $new_images;
                
                ##updating images
                if($customer_invoice_management->save())
                {
                    ##update customer invoice items
                    Customer_Invoice_Items::where('customer_invoice_management_id', $id)->delete();


                    $items_name = $request->item_name;
                    $items_quantity = $request->item_quantity;
                    $item_cost = $request->item_cost;

                    foreach($items_name as $index=>$item)
                    {

                        $input_items['item_name'] = $item;
                        $input_items['item_qunatity'] = $items_quantity[$index];
                        $input_items['item_cost'] = $item_cost[$index];
                        $input_items['customer_invoice_management_id'] = $customer_invoice_management->id;
                        $items = Customer_Invoice_Items::firstOrCreate($input_items);
                    }
                    // saving items


                    ###Saving formulas 
                    $cvm = customer_invoice_management::find($id);
                    $items_cost = array();
                    $items_quantity  = array();
                    $total_items_cost = array();
                    // calculatigng items cost
                    foreach( $cvm->items as $item)
                    {
                        array_push($items_cost,$item->item_cost);
                        array_push($items_quantity,$item->item_qunatity);
                    }
        
                    
                    foreach ($items_cost as $index=>$item)
                    {
                        $total = floatval($item) * floatval($items_quantity[$index]);
                        array_push($total_items_cost,$total);
                    }
        
                    
                    $sub_total_amount = array_sum($total_items_cost);
                    
                    ##before tax total
                    $before_tax_total = floatval($sub_total_amount) - floatval($cvm->penality_deduction_amount);
                
                    ##tax body amount
        
                    $tax_amount = $before_tax_total * floatval($cvm->tax_body_percentage / 100);
                
                    ##total amount
                    $total_amount = $before_tax_total + $tax_amount;
        
                    ##sales tax  Sales Tax WH at Source
                    $sales_tax_wh_at_source =  $tax_amount * floatval($cvm->sales_tax_source_percentage / 100);
                
                    ##After Tax Total
                    $after_tax_total  = $total_amount - floatval($cvm->after_tax_deduction);
        
                    ##withholding tax 1
                    $wh_tax_1 = $after_tax_total * floatval($cvm->withhold_tax1_percentage / 100);
        
                    ##withholding tax 2
                    $wh_tax_2 =  $total_amount * floatval($cvm->withhold_tax2_percentage / 100);
                    
                    ##total after deductions
                    $total_after_deductions = $total_amount - $sales_tax_wh_at_source - $wh_tax_1 - $wh_tax_2;
        
                    ##net income
                    $net_income =  $before_tax_total - $wh_tax_1 -  $wh_tax_2;
        
                    $net_income =  $before_tax_total - $wh_tax_1 -  $wh_tax_2;
                    
                    $cvm->total_after_deductions = $total_after_deductions;

                    $cvm->save();
                
                    ###saving formulas
  



                    Session::flash('created', 'Customer Invoice updated Successfully');

                    return redirect()->route('customerinvoice.index');


                }
                else{
                    Session::flash('error','Error updating Customer Invoice!');
                    return redirect()->back()->withInput();
                }
            }
            catch(Exception $e)
            {
                Session::flash('error',$e->getMessage());
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
    public function destroy($id)
    {
        //
    }

    public function getAjaxCustomerInvoice(Request $request){
        if (Auth::user()->can($this->authR))
        {
            if ($request->ajax()) {

                $data = customer_invoice_management::orderby('id','desc')->get();

                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                
                    $actionBtn = '<a href="'.route('customerinvoice.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                    <a href="'.route('customerinvoice.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;';
                    // <a  onclick="deleteItem('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>';
                    return $actionBtn;
                })->addColumn('checkbox',function($row){
                    $checkBtn = '<input type="checkbox" class="item_check"  value="'.$row->id.'">';
                    return $checkBtn;
                })
                ->addColumn('invoice_number',function($row){
                    $checkBtn = $row->invoice_number;
                    return $checkBtn;
                })
                ->addColumn('title',function($row){
                    $checkBtn = $row->title;
                    return $checkBtn;
                })

                ->addColumn('date_of_invoicing',function($row){
                    $checkBtn = date('d-m-Y',strtotime($row->date_of_invoicing));
                    return $checkBtn;
                    
                })

                ->addColumn('region',function($row){
                    $checkBtn = $row->region;
                    return $checkBtn;
                })

                ->addColumn('po_balance',function($row){
                    $checkBtn = $row->po_balance;
                    return $checkBtn;
                })

                ->addColumn('customer_name',function($row){
                    $checkBtn = $row->customer->name;
                    return $checkBtn;
                })

                
                ->addColumn('invoice_status',function($row){
                    $checkBtn = '<b>'.$row->invoice_status.'</b>';
                    return $checkBtn;
                })

    
                ->rawColumns(['action','checkbox','invoice_number','title','date_of_invoicing','region','po_balance','customer_name','invoice_status'])
                ->make(true);

            }
        } 
        else{
            return redirect()->route('not_authorized');
        }
    }

    public function getLastInsertedInvoice(Request $request){

        $po_id = $request->po_id;

        $customer_PO_balance_logs = Customer_PO_balance_logs::where('customer_po_id',$po_id)->orderBy('id','desc')->first();

        return response()->json(['succes'=>'true','customer_PO_balance_logs'=>$customer_PO_balance_logs],200);

    }
}
