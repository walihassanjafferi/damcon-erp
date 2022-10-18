<?php

namespace App\Http\Controllers\User\taxationmanagement;

use App\Models\Bankaccounts;
use App\Models\Suppliers;
use App\Models\Supplier_tax_ledger;
use App\Models\SupplierTaxPaymentsManagement;
use App\Models\SupplierTaxPaymentLedger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\BankTransactionTrait;
use App\Traits\FileAttachmentsTrait as FileUploader;
use Session;
use DataTables;
use DB;



class SupplierTaxPaymentsManagementController extends Controller
{
    private $path    = 'user.taxationmanagement.supplier_tax_payments_management';
    private $authR   = 'supplier_tax_payments_management';
   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->can($this->authR))
        {

            if ($request->ajax()) {

                $data = SupplierTaxPaymentsManagement::orderBy('id','desc')->get();
    
               return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('action', function($row){
                        // <a  onclick="deleteItem('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>
                      //  <a href="'.route('directorwithdraw.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>'
                         $actionBtn = '<a href="'.route('suppliertaxpayment.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp';
                         return $actionBtn;
                     })
                     ->addColumn('checkbox',function($row){
                        $checkBtn = '<input type="checkbox" class="item_check"  value="'.$row->id.'">';
                        return $checkBtn;
                    })

                    ->addColumn('supplier_name',function($row){
                        $checkBtn = $row->Suppliers->name;
                        return $checkBtn;
                    })

                    ->addColumn('payable_tax',function($row){
                        $checkBtn = number_format($row->payable_tax);
                        return $checkBtn;
                    })

                    ->addColumn('manual_adjustments',function($row){
                        $checkBtn = number_format($row->manual_adjustments);
                        return $checkBtn;
                    })

                    ->addColumn('final_amount',function($row){
                        $checkBtn = number_format($row->final_amount);
                        return $checkBtn;
                    })
        
                    ->rawColumns(['action','checkbox','tax_id'])    

                    ->make(true);
            }
            else{
                return view($this->path.'.index');

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
            $supplies = Suppliers::get(['name','id']);
            $bankaccounts = Bankaccounts::get(['name','id','title']);

            return view($this->path.'.create',compact('supplies','bankaccounts'));
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
        if(Auth::user()->can($this->authR))
        {
            try {
                DB::beginTransaction();

                $supplier_tax_payment = new SupplierTaxPaymentsManagement();
                $supplier_tax_payment->title = $request->title;
                $supplier_tax_payment->supplier_id = $request->supplier_id;
                $supplier_tax_payment->payable_tax = $request->payable_tax;
                $supplier_tax_payment->manual_adjustments = $request->manual_adjustments;
                $supplier_tax_payment->final_amount = $request->final_amount;
                $supplier_tax_payment->payment_method = $request->payment_method;
                $supplier_tax_payment->final_amount = $request->final_amount;
                if($request->has('bank_id'))
                {
                    $supplier_tax_payment->cash_deposit_bank_id = $request->bank_id;
                }
                if($request->has('cheque_title'))
                {
                    $supplier_tax_payment->cheque_title = $request->cheque_title;
                }
                if($request->has('cheque_number'))
                {
                    $supplier_tax_payment->cheque_number = $request->cheque_number;

                }
                $supplier_tax_payment->date = $request->date;
                $supplier_tax_payment->payment_details = $request->payment_details;
                $supplier_tax_payment->manual_adjustment_comments = $request->manual_adjustment_comments;
                $supplier_tax_payment->comments = $request->comments;

                  // handling images
                  $image_names=[];

                  //Upload Files
                  if($request->hasfile('document_file'))
                  {
                      foreach($request->file('document_file') as $image)
                      {
                          $filename = FileUploader::uploadFile($image,"supplier_tax_payments","supplier_tax_paymmet");
                          array_push($image_names,$filename);
                      }
                      $supplier_tax_payment->document_file  = json_encode($image_names);
                  }
  

                
                $ledger_data[] = json_decode($request->ledger_data);
              
                if($supplier_tax_payment->save())
                {
                    foreach($ledger_data[0] as $index=>$ldata)
                    {  
                        // changing tax ledger status

                        $supplier_tax_ledger = Supplier_tax_ledger::find($ldata->ledger_id);
                        $supplier_tax_ledger->tax_status = "paid";
                        $supplier_tax_ledger->save();

                        $supplier_ledger = new SupplierTaxPaymentLedger();
                        $supplier_ledger->supplier_tax_payment_id = $supplier_tax_payment->id;
                        $supplier_ledger->ledger_id = $ldata->ledger_id;
                        $supplier_ledger->payment_title = $ldata->payment_title;
                        $supplier_ledger->tax_ledger_amount = $ldata->tax_ledger_amount;
                        $supplier_ledger->save();


                    }


                    if($request->has('bank_id') && $request->payment_method == 'direct') 
                    {
                         #adding bank transaction
                        $bank = Bankaccounts::find($supplier_tax_payment->cash_deposit_bank_id);
                        $bank->current_balance = $bank->current_balance -  $supplier_tax_payment->final_amount;
                        $bank->avaliable_funds =  $bank->avaliable_funds - $supplier_tax_payment->final_amount;
                        if($bank->save())
                        {   
                            $bank->refresh();
                            $user_id = Auth()->user()->id;
                            $transaction_log = BankTransactionTrait::logTransaction(
                                $bank->id,
                                $user_id,
                                $supplier_tax_payment->final_amount,
                                'debited',
                                $bank->avaliable_funds,
                                "Supplier Tax Payment",
                                $supplier_tax_payment->date
                            );
                        }
                        ##adding bank transaction
                    }

                   

                    DB::commit();
                    Session::flash('success','Supplier Tax Payment added successfully!');
                    return redirect()->route('suppliertaxpayment.index');
                }
                else{
                    Session::flash('error','Error Occured');
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
     * @param  \App\Models\SupplierTaxPaymentsManagement  $supplierTaxPaymentsManagement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $id = decrypt($id);

            $supplier_tax_payment_management = SupplierTaxPaymentsManagement::find($id);

            $supplier_tax_payment_ledger = SupplierTaxPaymentLedger::where('supplier_tax_payment_id',$id)->get();
            
            return view($this->path.'.view',compact('supplier_tax_payment_management','supplier_tax_payment_ledger'));

        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierTaxPaymentsManagement  $supplierTaxPaymentsManagement
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
     * @param  \App\Models\SupplierTaxPaymentsManagement  $supplierTaxPaymentsManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierTaxPaymentsManagement $supplierTaxPaymentsManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierTaxPaymentsManagement  $supplierTaxPaymentsManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierTaxPaymentsManagement $supplierTaxPaymentsManagement)
    {
        //
    }

    public function get_supplier_tax_ledger(Request $request){

    
        $supplier_id = $request->supplier_id;

        $supplier_tax_ledger = Supplier_tax_ledger::where('supplier_id',$supplier_id)->where('tax_status',NULL)->get();

        return response()->json(['supplier_ledgers'=>$supplier_tax_ledger],200);

    }

    public function ajaxGetSuppliertaxpayments(){
        if(Auth::user()->can($this->authR))
        {
            if ($request->ajax()) {

                $data = SupplierTaxPaymentsManagement::orderBy('id','desc')->get();
    
               return Datatables::of($data)
                    ->addIndexColumn()

                    ->addColumn('action', function($row){
                        // <a  onclick="deleteItem('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>
                      //  <a href="'.route('directorwithdraw.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>'
                         $actionBtn = '<a href="'.route('suppliertaxpayment.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp';
                         return $actionBtn;
                     })
                     ->addColumn('checkbox',function($row){
                        $checkBtn = '<input type="checkbox" class="item_check"  value="'.$row->id.'">';
                        return $checkBtn;
                    })

                    ->addColumn('supplier_name',function($row){
                        $checkBtn = $row->Suppliers->name;
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
