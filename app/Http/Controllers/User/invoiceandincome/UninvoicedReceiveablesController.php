<?php

namespace App\Http\Controllers\User\invoiceandincome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Taxation_bodies;
use App\Models\Project;
use App\Models\UninvoicedReceiveable;
use App\Models\CustomerPosManagement;
use App\Models\Customer;
use App\Models\customer_invoice_management;
use App\Models\Customer_Invoice_Items;
use App\Traits\FileAttachmentsTrait as FileUploader;
use App\Traits\TaxBodyledgerTrait as TaxBodyLedger;
use App\Models\Customer_PO_balance_logs;
use File;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Auth;
use Session;
use Exception;
use DB;

class UninvoicedReceiveablesController extends Controller
{
    private $path    = 'user.invoicingincomemanagement.uninvoicedreceiveables';
    private $authR   = 'uninvoiced-receiveables';
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
            $projects = Project::where('status',1)->pluck('name','id')->toArray();
            $tax_bodies = Taxation_bodies::pluck('name','id')->toArray();

            return view($this->path.'.create',compact('projects','tax_bodies'));
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
    
            try{

                $uninvoiced = new UninvoicedReceiveable();
                $uninvoiced->title = $request->title;
                $uninvoiced->date = $request->date;
                $uninvoiced->project_id = $request->project_id;
                $uninvoiced->month = $request->month;
                $uninvoiced->region = $request->region;
                $uninvoiced->reason_of_uninvoicing = $request->reason_of_uninvoicing;
                $uninvoiced->estimated_qty = $request->estimated_qty;
                $uninvoiced->estimated_unit_price = $request->estimated_unit_price;
                $uninvoiced->sales_tax_percentage = $request->sales_tax_percentage;
                $uninvoiced->tax_type_comment = $request->tax_type_comment;
                $uninvoiced->sales_tax_source_percentage = $request->sales_tax_source_percentage;
                $uninvoiced->withhold_tax_percentage = $request->withhold_tax_percentage;
                $uninvoiced->wh_type_comments = $request->wh_type_comments;
                $uninvoiced->tax_id = $request->tax_id;
                $uninvoiced->tax_body_percentage = $request->tax_body_percentage;
                $uninvoiced->type_of_invoice = 'un-invoiced';
                // saving images
    
                $new_images = [];
                    
                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,'customerUn-Invoice','customer_uninvoice');
                        array_push($new_images,$filename);
                    }
                }
              
                $uninvoiced->document_file = json_encode($new_images);
    
                if($uninvoiced->save())
                {
                   
                    Session::flash('created', 'Customer Un-Invoiced Added Successfully');

                    return redirect()->route('uninvoicedreceivables.index');


                }
                else{
                    Session::flash('error','Error Adding Un-Invoiced Receiveables!');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $id = decrypt($id);
           
            $uninvoiced = UninvoicedReceiveable::find($id);

            // getting PO

            $customer_po = CustomerPosManagement::with('toProject')->get();
            
            $customer = Customer::where('status',1)->get();

            $subbtotal = $uninvoiced->estimated_qty * $uninvoiced->estimated_unit_price;
            
            $taxamount = $subbtotal * ($uninvoiced->tax_body_percentage / 100);

            $totalamount = $subbtotal + $taxamount;

            $sales_tax_wh_source =  $taxamount * ($uninvoiced->sales_tax_source_percentage / 100);

            $wh_tax_1 = $totalamount * ($uninvoiced->withhold_tax_percentage / 100);

            $customer_cheque = $totalamount -  $sales_tax_wh_source - $wh_tax_1;
           
            return view($this->path.'.view',compact('uninvoiced','subbtotal','totalamount','taxamount','sales_tax_wh_source','wh_tax_1','customer_cheque','customer_po','customer'));

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
           
            $uir = UninvoicedReceiveable::find($id);
            $tax_bodies = Taxation_bodies::pluck('name','id')->toArray();
            $projects = Project::where('status',1)->pluck('name','id')->toArray();
            return view($this->path.'.edit',compact('uir','projects','tax_bodies'));
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
      
        if(Auth::user()->can($this->authR))
        {
    
            try{
                $id = decrypt($id);
                $uninvoiced = UninvoicedReceiveable::find($id);
                $uninvoiced->title = $request->title;
                $uninvoiced->date = $request->date;
                $uninvoiced->project_id = $request->project_id;
                $uninvoiced->month = $request->month;
                $uninvoiced->region = $request->region;
                $uninvoiced->reason_of_uninvoicing = $request->reason_of_uninvoicing;
                $uninvoiced->estimated_qty = $request->estimated_qty;
                $uninvoiced->estimated_unit_price = $request->estimated_unit_price;
                $uninvoiced->sales_tax_percentage = $request->sales_tax_percentage;
                $uninvoiced->tax_type_comment = $request->tax_type_comment;
                $uninvoiced->sales_tax_source_percentage = $request->sales_tax_source_percentage;
                $uninvoiced->withhold_tax_percentage = $request->withhold_tax_percentage;
                $uninvoiced->wh_type_comments = $request->wh_type_comments;
                $uninvoiced->tax_id = $request->tax_id;
                $uninvoiced->tax_body_percentage = $request->tax_body_percentage;
                $uninvoiced->type_of_invoice = 'un-invoiced';
                // saving images

                
                ##updating images
            
                $images  = json_decode($uninvoiced->document_file);
    
                $remove_images = [];
                $new_images    = [];
    
                if(isset($request->remove_images)){
                 
                    $remove_images = explode(',',$request->remove_images);
                    foreach($remove_images as $img)
                    {
                        FileUploader::RemoveFile($img,'customerUn-Invoice');
                    }
                }
    
                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,'customerUn-Invoice','customer_uninvoice');
                        array_push($new_images,$filename);
                    }
                }
    
                if($uninvoiced->document_file !=null){
                    foreach($images as $img)
                    {
                        if (!in_array($img,$remove_images)) {
                            array_push($new_images,$img);
                        }
                    }
                }
    
               
                $uninvoiced->document_file = $new_images;
               
               ##updating images
    
              
    
                if($uninvoiced->save())
                {
                   
                    Session::flash('created', 'Customer Un-Invoiced Updated Successfully');

                    return redirect()->back();


                }
                else{
                    Session::flash('error','Error updating Un-Invoiced Receiveables!');
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


    public function getAjaxUninvoiced(Request $request){
        if (Auth::user()->can($this->authR))
        {
            if ($request->ajax()) {

                $data = UninvoicedReceiveable::where('converted_to_invoice',0)->orderby('id','desc')->get();

                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                
                    $actionBtn = '<a href="'.route('uninvoicedreceivables.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                    <a href="'.route('uninvoicedreceivables.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;';
                    // <a  onclick="deleteItem('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>';
                    return $actionBtn;
                })->addColumn('checkbox',function($row){
                    $checkBtn = '<input type="checkbox" class="item_check"  value="'.$row->id.'">';
                    return $checkBtn;
                })
                ->addColumn('title',function($row){
                    $checkBtn = $row->title;
                    return $checkBtn;
                })

                ->addColumn('date',function($row){
                    $checkBtn = date('d-M-Y',strtotime($row->date));
                    return $checkBtn;
                    
                })

                ->addColumn('project',function($row){
                    $checkBtn = $row->project->name;
                    return $checkBtn;
                })

                ->addColumn('region',function($row){
                    $checkBtn = $row->region;
                    return $checkBtn;
                })

                ->addColumn('month',function($row){
                    $checkBtn = $row->month;
                    return $checkBtn;
                })

    
                ->rawColumns(['action','checkbox','title','date','project','region','month'])
                ->make(true);

            }
        } 
        else{
            return redirect()->route('not_authorized');
        }
    }


    public function convertToInvoice(Request $request){
       // dd($request->all());
        try{

            DB::beginTransaction();

            
            $invoice_number = customer_invoice_management::where('invoice_number',$request->invoice_number)->first();

            if($invoice_number)
            {   
                Session::flash('error',"Duplicate invoice number!");
                return redirect()->back()->withInput();
            }

            $uninvoiced_receiveable =  UninvoicedReceiveable::find($request->uninvoiced_id);

            //dd($uninvoiced_receiveable);
            
            $customer_invoice_management = new customer_invoice_management();
            $customer_invoice_management->invoice_number = $request->invoice_number;
            $customer_invoice_management->title = $uninvoiced_receiveable->title;
            $customer_invoice_management->date_of_invoicing = $uninvoiced_receiveable->date;
            $customer_invoice_management->detail_of_invoice = $request->detail_of_invoice;
            $customer_invoice_management->customer_po_id = $request->customer_po_id;
            $customer_invoice_management->project_id = $request->project_id;
            $customer_invoice_management->po_balance = $request->po_balance;
            $customer_invoice_management->customer_name = $request->customer_name;
            $customer_invoice_management->customer_id = $request->customer_id;
            $customer_invoice_management->invoice_month = $uninvoiced_receiveable->month;
            $customer_invoice_management->region = $uninvoiced_receiveable->region;
            $customer_invoice_management->tax_id = $uninvoiced_receiveable->tax_id;
            $customer_invoice_management->tax_body_description = $uninvoiced_receiveable->tax_body_description;
            $customer_invoice_management->taxation_month = $uninvoiced_receiveable->taxation_month ?? '';
            $customer_invoice_management->tax_body_percentage = $uninvoiced_receiveable->tax_body_percentage;
            $customer_invoice_management->tax_type_comments = $uninvoiced_receiveable->tax_type_comments;
            $customer_invoice_management->penality_deduction_amount = $request->penality_deduction_amount;
            $customer_invoice_management->penality_deduction_comment = '';
            $customer_invoice_management->sales_tax_source_percentage = $request->sales_tax_source_percentage;
            $customer_invoice_management->after_tax_deduction = $request->after_tax_deduction;
            $customer_invoice_management->after_tax_deduction_comments = '';
            $customer_invoice_management->withhold_tax1_percentage = $request->withhold_tax1_percentage;
            $customer_invoice_management->withhold_tax2_percentage = $request->withhold_tax2_percentage;
            $customer_invoice_management->comments = $request->comments;

            if(!empty($uninvoiced_receiveable->document_file))
            {
                $images = json_decode($uninvoiced_receiveable->document_file);

                 foreach($images as $img)
                {
                    $str = $img;
                    $imgext = explode(".",$str);
                    if($imgext[1] != 'pdf')
                    {
            
                        File::copy(storage_path("app\public\customerUn-Invoice/$img"), storage_path("app\public\customerInvoice/$img"));
                    }
                 else{

                        File::copy(storage_path("app\public\customerUn-Invoice/PDF/$img"),storage_path("app\public\customerInvoice/PDF/$img"));
                 }

                 }

               $customer_invoice_management->document_file = $uninvoiced_receiveable->document_file;
            }

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

                    $uninvoiced_receiveable->converted_to_invoice = 1;
                    $uninvoiced_receiveable->save();

            }



            DB::commit();

            Session::flash('created', 'Customer Invoice Added Successfully');

            return redirect()->route('customerinvoice.index');
        
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
            DB::rollback();
            Session::flash('error',$e->getMessage());
            return redirect()->back()->withInput();
        }

    }


}
