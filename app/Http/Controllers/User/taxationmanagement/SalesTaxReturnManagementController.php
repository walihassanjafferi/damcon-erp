<?php

namespace App\Http\Controllers\User\taxationmanagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Taxation_bodies;
use App\Models\customer_invoice_management;
use App\Models\TaxBodyLedger;
use App\Models\AssetsPurchaseOrdersManagement;
use App\Models\ServicesPurchaseOrdersManagement;
use App\Models\RentalPurchaseOrdersManagement;
use App\Models\CustomerPosManagement;
use App\Models\SupplierPosManagement;
use App\Models\Bankaccounts;
use App\Models\Salestaxreturnmanagement;
use App\Models\Sales_tax_return_invoices_po;
use App\Traits\FileAttachmentsTrait as FileUploader;
use DataTables;
use Auth;
use Session;
use Exception;
use DB;
use Carbon\Carbon;


class SalesTaxReturnManagementController extends Controller
{

    protected $path = 'user.taxationmanagement.sales_tax_return_management';
    private $authR   = 'sales_tax_return_management';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->path.'.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tax_bodies = Taxation_bodies::pluck('name','id')->toArray();
        $banks = Bankaccounts::all();


        return view($this->path.'.create',compact('tax_bodies','banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        if(Auth::user()->can($this->authR)){
            try{
                DB::beginTransaction();

                $salestaxreturn = new SalesTaxReturnManagement();
                $salestaxreturn->tax_id = $request->tax_id;
                $salestaxreturn->taxation_month = $request->taxation_month;
                $salestaxreturn->payable_taxbody = $request->payable_taxbody;
                $salestaxreturn->manual_adjustments = $request->manual_adjustments;
                $salestaxreturn->manual_adjustment_comments = $request->manual_adjustment_comments;
                $salestaxreturn->net_payable = $request->net_payable;

                if($request->has('cash_deposit_bank_id')) 
                {
                    $salestaxreturn->cash_deposit_bank_id = $request->cash_deposit_bank_id;
                }

                if($request->has('cheque_title')) 
                {
                    $salestaxreturn->cheque_title = $request->cheque_title;
                }

                if($request->has('cheque_number')) 
                {
                    $salestaxreturn->cheque_number = $request->cheque_number;
                }


                $salestaxreturn->date = $request->date;
                $salestaxreturn->amount = $request->amount;
                $salestaxreturn->payment_details = $request->payment_details;
                $salestaxreturn->comments = $request->comments;


                // handling images
                $image_names=[];

                //Upload Files
                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,"sales_tax_retums","Sales_tax");
                        array_push($image_names,$filename);
                    }
                    $salestaxreturn->document_file  = json_encode($image_names);
                }

                if($salestaxreturn->save()) 
                {
                     // handling invoices

                    $invoices_data = []; 

                    if(isset($request->invoice_data))
                    {
                        $invoices_data[] = json_decode($request->invoice_data);
                    }


                    if(count($invoices_data))
                    {
                        foreach($invoices_data as $index=>$idata)
                        {
                            $sales_invoice = new Sales_tax_return_invoices_po();
                            $sales_invoice->invoice_po_id = $idata[$index]->invoice_id;
                            $sales_invoice->sales_tax_return_id = $salestaxreturn->id;
                            $sales_invoice->type = "customer_invoice";
                            $sales_invoice->amount = $idata[$index]->amount;
                            $sales_invoice->adjusted_input_output = $idata[$index]->adjusted_output;
                            $sales_invoice->tax_id = $request->tax_id;
                            $sales_invoice->taxation_month = $request->taxation_month;
                            $sales_invoice->save();
                        }
                    }
                    
                    $supplier_po_data = [];

                    if(isset($request->supplier_po_data))
                    {
                        $supplier_po_data[] = json_decode($request->supplier_po_data);
                    }

                    $rental_po_data = [];

                    if(isset($request->rental_po_data))
                    {
                        $rental_po_data[] = json_decode($request->rental_po_data);
                    }

                    $asset_po_data = [];

                    if(isset($request->assets_po_data))
                    {
                        $asset_po_data[] = json_decode($request->assets_po_data);
                    }

                    $services_po_data = [];
                    
                    if(isset($request->services_po_data))
                    {
                        $services_po_data[] = json_decode($request->services_po_data);
                    }
                    
                    
                    // supplier po data
                    if(count($supplier_po_data))
                    {
                        
                        foreach($supplier_po_data && $supplier_po_data as $index=>$idata)
                        {
                            $sales_invoice = new Sales_tax_return_invoices_po();
                            $sales_invoice->invoice_po_id = $idata[$index]->po_number;
                            $sales_invoice->sales_tax_return_id = $salestaxreturn->id;
                            $sales_invoice->type = "supplier_po";
                            $sales_invoice->amount = $idata[$index]->amount;
                            $sales_invoice->adjusted_input_output = $idata[$index]->adjusted_input ?? 0;
                            $sales_invoice->tax_id = $request->tax_id;
                            $sales_invoice->taxation_month = $request->taxation_month;
                            $sales_invoice->save();
                        }
                    }
                   

                    // rental po data
                    if(count($rental_po_data))
                    {
                        foreach($rental_po_data as $index=>$idata)
                        {
                            $sales_invoice = new Sales_tax_return_invoices_po();
                            $sales_invoice->invoice_po_id = $idata[$index]->po_number;
                            $sales_invoice->sales_tax_return_id = $salestaxreturn->id;
                            $sales_invoice->type = "rental_po";
                            $sales_invoice->amount = $idata[$index]->amount;
                            $sales_invoice->adjusted_input_output = $idata[$index]->adjusted_input ?? 0;
                            $sales_invoice->tax_id = $request->tax_id;
                            $sales_invoice->taxation_month = $request->taxation_month;
                            $sales_invoice->save();
                        }
                    }
                    

                    // assets po data
                    if(count($asset_po_data))
                    {
                        foreach($asset_po_data as $index=>$idata)
                        {
                            $sales_invoice = new Sales_tax_return_invoices_po();
                            $sales_invoice->invoice_po_id = $idata[$index]->po_number;
                            $sales_invoice->sales_tax_return_id = $salestaxreturn->id;
                            $sales_invoice->type = "assets_po";
                            $sales_invoice->amount = $idata[$index]->amount;
                            $sales_invoice->adjusted_input_output = $idata[$index]->adjusted_input ?? 0;
                            $sales_invoice->tax_id = $request->tax_id;
                            $sales_invoice->taxation_month = $request->taxation_month;
                            $sales_invoice->save();
                        }
                    }

                    // services po data
                    if(count($services_po_data))
                    {
                        foreach($services_po_data as $index=>$idata)
                        {
                            $sales_invoice = new Sales_tax_return_invoices_po();
                            $sales_invoice->invoice_po_id = $idata[$index]->po_number;
                            $sales_invoice->sales_tax_return_id = $salestaxreturn->id;
                            $sales_invoice->type = "services_po";
                            $sales_invoice->amount = $idata[$index]->amount;
                            $sales_invoice->adjusted_input_output = $idata[$index]->adjusted_input ?? 0;
                            $sales_invoice->tax_id = $request->tax_id;
                            $sales_invoice->taxation_month = $request->taxation_month;
                            $sales_invoice->save();
                        }
                    }
                   
                    


                    DB::commit();
                    Session::flash('success',"Sales tax return Management added successfully!");
                    return redirect()->back()->withInput();

                }
                else{
                    Session::flash('error','Error Occured!');
                    return redirect()->back()->withInput();
                }


               
            }
            catch(Excepption $e)
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
        if(Auth::user()->can($this->authR))
        {
            $id = decrypt($id);

            $sales_tax_return_management = SalesTaxReturnManagement::find($id);

            $sales_tax_return_incoices_po = Sales_tax_return_invoices_po::where('sales_tax_return_id',$id)->groupBy('type')->get();
            return view($this->path.'.view',compact('sales_tax_return_management','sales_tax_return_incoices_po'));

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
        //
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
        //
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

    public function getTaxMonthData(Request $request){

        $month = $request->tax_month;

        $tax_body_id = $request->tax_body_id;

        $startDate = Carbon::parse($month)->startOfMonth()->format('Y-m');
        
        $endDate = Carbon::parse($month)->endOfMonth()->format('Y-m');

        $customer_invoice = customer_invoice_management::where('tax_id',$tax_body_id)->whereBetween('taxation_month', [$startDate, $endDate])->get();

        $asset_purchase_order = AssetsPurchaseOrdersManagement::where('tax_body_id',$tax_body_id)->whereBetween('taxation_month', [$startDate, $endDate])->get();

        $services_purchase_order = ServicesPurchaseOrdersManagement::where('tax_body_id',$tax_body_id)->whereBetween('taxation_month', [$startDate, $endDate])->get();

        $rental_purchase_order = RentalPurchaseOrdersManagement::where('tax_body_id',$tax_body_id)->whereBetween('taxation_month', [$startDate, $endDate])->get();

        $supplier_purchase_order = SupplierPosManagement::where('tax_body_id',$tax_body_id)->whereBetween('taxation_month', [$startDate, $endDate])->get();

        return response()->json([
            'success' => true,
            'customer_invoices' => $customer_invoice,
            'asset_purchase_order' => $asset_purchase_order,
            'services_purchase_order'=> $services_purchase_order,
            'rental_purchase_order'=> $rental_purchase_order,
            'supplier_purchase_order'=> $supplier_purchase_order
        ],200);
       

    }   


    public function getAjaxSalestax(Request $request){
        if(Auth::user()->can($this->authR))
        {
            if ($request->ajax()) {

                $data = Salestaxreturnmanagement::orderBy('id','desc')->get();
    
               return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('action', function($row){
                        // <a  onclick="deleteItem('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>
                      //  <a href="'.route('directorwithdraw.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>'
                         $actionBtn = '<a href="'.route('sales_tax_return_management.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp';
                         return $actionBtn;
                     })
                     ->addColumn('checkbox',function($row){
                        $checkBtn = '<input type="checkbox" class="item_check"  value="'.$row->id.'">';
                        return $checkBtn;
                    })

                    ->addColumn('tax_id',function($row){
                        $checkBtn = $row->taxBody->name;
                        return $checkBtn;
                    })

        
                    ->rawColumns(['action','checkbox','tax_id'])    

                    ->make(true);
            }
        } 
        else{
            return redirect()->route('not_authorized');
        }
    }
}
