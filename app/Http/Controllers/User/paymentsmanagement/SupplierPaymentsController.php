<?php

namespace App\Http\Controllers\User\paymentsmanagement;

use App\Http\Requests\SupplierPaymentRequest;
use App\Models\Bankaccounts;
use App\Models\SupplierPayments;
use App\Models\SupplierPosManagement;
use App\Traits\FileAttachmentsTrait as FileUploader;
use Illuminate\Http\Request;
use App\Models\Suppliers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\SupplierTaxledgerTrait as SupplierLedger;
use App\Traits\BankTransactionTrait;
use Session;
use DataTables;
use DB;

class SupplierPaymentsController extends Controller
{

    private $path    = 'user.paymentmanagement.supplierpayments';
    private $authR   = 'supplier_payments_management_modules';
    private $folderN = 'supplier_payments';
    private $fileN   = 'S_P';

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

                $data = SupplierPayments::orderby('id','desc')->get(['id','po_id','bank_id','date','amount','supplier_id']);

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $actionBtn = '<a href="'.route('supplier_payment_management.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                                      <a href="'.route('supplier_payment_management.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;
                                      <a  onclick="deleteOrder('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>';
                        return $actionBtn;
                    })->addColumn('supplier',function($row){
                        return $row->supplierName->name;
                    })->addColumn('bank_name',function($row){
                          if(isset($row->banks)){return $row->banks->name.'('.$row->banks->title.')'; } 
                    })->addColumn('checkbox',function($row){
                        $checkBtn = '<input type="checkbox" class="order_check"  value="'.$row->id.'">';
                        return $checkBtn;
                    })
                    ->rawColumns(['action','checkbox','batches_name','bank_name'])
                    ->make(true);
            }else{
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
            $bank_accounts          = Bankaccounts::get(['name','id','title']);
            //$supplier_pos           = SupplierPosManagement::get(['purchase_od_number','id','supplier_id']);


            $suppliers = DB::table('suppliers as s')->join('suppliers_types as st','s.suppliers_types_id','st.id')->select('s.id','s.name as supplier_name','s.balance','st.name as type')->get();

            return view($this->path.'.create',compact('bank_accounts','suppliers'));
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
        DB::beginTransaction();

        if(Auth::user()->can($this->authR))
        {
            try {
               
                $amount = (float)str_replace(',', '', $r->amount);

                if($r->has('bank_id') && $r->payment_method == 'direct') 
                {
                     ##checking bank balance
                    $bank = Bankaccounts::find($r->bank_id);
                    if($amount > $bank->avaliable_funds)
                    {
                        Session::flash('error','Selected Bank '.$bank->name.' ('.$bank->title.') '.'has not sufficient Balance!');
                        return redirect()->back()->withInput();
                    }
                    ##checking bank balance
                }
               
                $supplier_payments                          = new SupplierPayments();
                $supplier_payments->user_id                 = Auth::id();
               // $supplier_payments->po_id                   = $r->po_id;
                $supplier_payments->supplier_id             = $r->supplier_id;
                $supplier_payments->title                   = $r->title;
                $supplier_payments->supplier_type           = $r->supplier_id;
                $supplier_payments->payment_method          = $r->payment_method;
                if($r->has('bank_id')) 
                {
                    $supplier_payments->bank_id                 = $r->bank_id;
                }

                if($r->has('cheque_title')) 
                {
                    $supplier_payments->cheque_title            = $r->cheque_title;
                }

                if($r->has('cheque_number')) 
                {
                    $supplier_payments->cheque_number           = $r->cheque_number;
                }
                $supplier_payments->date                    = $r->date;
                $supplier_payments->amount                  = $amount;
                $supplier_payments->payment_details         = $r->payment_details;
                $supplier_payments->comments                = $r->comments;

                $image_names=[];

                //Upload Files
                if($r->hasfile('document_file'))
                {
                    foreach($r->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,$this->folderN,$this->fileN);
                        array_push($image_names,$filename);
                    }
                    $supplier_payments->document_file  = json_encode($image_names);
                }

                //Save Files
                if($supplier_payments->save())
                {
                    if($r->has('bank_id') && $r->payment_method == 'direct') 
                    {
                         ##adding bank transaction
                        $bank = Bankaccounts::find($supplier_payments->bank_id);
                        $bank->current_balance = $bank->current_balance -  $supplier_payments->amount;
                        $bank->avaliable_funds =  $bank->avaliable_funds - $supplier_payments->amount;
                        if($bank->save())
                        {   
                            $bank->refresh();
                            $user_id = Auth()->user()->id;
                            $transaction_log = BankTransactionTrait::logTransaction(
                                $bank->id,
                                $user_id,
                                $amount,
                                'debited',
                                $bank->avaliable_funds,
                                "Supplier Payment",
                                $amount,
                                0,
                                $supplier_payments->comments,
                                '',
                                $supplier_payments->date
                            );
                        }
                        ##adding bank transaction
                    }

                   


                    ##adding amount to supplier ledger
                    // $supplier_ledger = SupplierLedger::add_supplier_tax(
                    //     $r->supplier_id,
                    //     $supplier_payments->id,
                    //     "payment_in",
                    //     "supplier_payment",
                    //     'Supplier Payment',
                    //     $amount
                    // );


                    ##adding supplier payment

                    SupplierLedger::add_supplier_payment_pay(
                        $supplier_payments->title,
                        $supplier_payments->supplier_id, 
                        0, 
                        $amount
                    );


                    
                    DB::commit();
                    Session::flash('created', 'Supplier Payments Added Successfully');

                    return redirect()->route('supplier_payment_management.index');
                }
                else{

                    Session::flash('error', 'Error adding Supplier Payments');
                    return redirect()->back()->withInput();
                }

            }catch(Exception $e){
                DB::rollback();
                Session::flash('error', 'Error adding Supplier Payments');
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
     * @param  \App\Models\SupplierPayments  $supplierPayments
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $supplier_payments      = SupplierPayments::find(decrypt($id));

            return view($this->path.'.view',compact('supplier_payments'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierPayments  $supplierPayments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can($this->authR))
        {

            $bank_accounts          = Bankaccounts::get(['name','id','title']);
           // $supplier_pos           = SupplierPosManagement::get(['purchase_od_number','id']);
            $supplier_payments      = SupplierPayments::find(decrypt($id));
        
            $suppliers = DB::table('suppliers as s')->join('suppliers_types as st','s.suppliers_types_id','st.id')->select('s.id','s.name as supplier_name','s.balance','st.name as type')->get();

            return view($this->path.'.edit',compact('bank_accounts','supplier_payments','suppliers'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierPayments  $supplierPayments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        if(Auth::user()->can($this->authR))
        {
            $id  = decrypt($id);
            try {

                $supplier_payments                          = SupplierPayments::find($id);
              //  $supplier_payments->po_id                   = $r->po_id;
                $supplier_payments->supplier_type           = $r->supplier_type;
                $supplier_payments->supplier_id             = $r->supplier_id;
                $supplier_payments->title                   = $r->title;
                $supplier_payments->payment_method          = $r->payment_method;
                $supplier_payments->bank_id                 = $r->bank_id;
                $supplier_payments->cheque_title            = $r->cheque_title;
                $supplier_payments->cheque_number           = $r->cheque_number;
                $supplier_payments->date                    = $r->date;
                $supplier_payments->amount                  = $r->amount;
                $supplier_payments->payment_details         = $r->payment_details;
                $supplier_payments->comments                = $r->comments;

                $images                                     = json_decode($supplier_payments->document_file);

                $remove_images = [];
                $new_images    = [];

                if(isset($r->remove_images)){
                    $remove_images = explode(',',$r->remove_images);
                    foreach($remove_images as $img)
                    {
                        FileUploader::RemoveFile($img,$this->folderN);
                    }
                }

                if($r->hasfile('document_file'))
                {
                    foreach($r->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,$this->folderN,$this->fileN);
                        array_push($new_images,$filename);
                    }
                }

                if($supplier_payments->document_file !=null){
                    foreach($images as $img)
                    {
                        if (!in_array($img,$remove_images)) {
                            array_push($new_images,$img);
                        }
                    }
                }
                $supplier_payments->document_file = $new_images;

                //Save Files

                //dd($supplier_payments);
                if($supplier_payments->update())
                {
                    // saving items
                    Session::flash('created', 'Supplier Payments Updated Successfully');
                    return redirect()->route('supplier_payment_management.index');
                }
                else{
                    Session::flash('error', 'Error updating Supplier Payments');
                    return redirect()->back()->withInput();
                }
            }catch(Exception $e){
                Session::flash('error', 'Error updating Supplier Payments');
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
     * @param  \App\Models\SupplierPayments  $supplierPayments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if(Auth::user()->can($this->authR))
        {
            try {
                $id = $request->id;
                $supplier_payments = SupplierPayments::find($id);
                if($supplier_payments)
                {
                    if($supplier_payments->document_file !=null){
                        foreach(json_decode($supplier_payments->document_file) as $img)
                        {
                            FileUploader::RemoveFile($img,$this->folderN);
                        }
                    }
                    $supplier_payments->delete();
                    return response()->json(['success' => true, 'message' => 'Supplier Payments deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Supplier Payments deletion failed'], 422);
                }
            }
            catch(Exception $e){
                Session::flash('error', 'Supplier Payments not Deleted');
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

                SupplierPayments::find($orderList)->each(function ($supplier_payments) {
                    if($supplier_payments)
                    {
                        if($supplier_payments->document_file !=null){
                            foreach(json_decode($supplier_payments->document_file) as $img)
                            {
                                FileUploader::RemoveFile($img,$this->folderN);
                            }
                        }
                        $supplier_payments->delete();
                    }
                    else{
                        return response()->json(['error' => true, 'message' => 'Supplier Payments deletion failed'], 422);
                    }
                });
                return response()->json(['success' => true, 'message' => 'Supplier Payments deleted Successfully'], 200);

            }catch(Exception $e){
                Session::flash('error', 'Supplier Payments not Deleted');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    public function getSupplierPO(Request $r)
    {
        if(Auth::user()->can($this->authR))
        {
            try {
             //   $orderList = $r->id;

                ///$supplier_po =SupplierPosManagement::find($orderList);
                $supplier_type = Suppliers::find($r->id)->join('suppliers_types','suppliers.suppliers_types_id','=','suppliers_types.id')->select('suppliers_types.name')->first();
                return $supplier_type;
                if($supplier_po)
                {
                    return response()->json(['success' => true, 'message' => ($supplier_po->type == 1) ? 'Services':'Parts','supplier_type'=>$supplier_type], 200);
                }
                else{
                return response()->json(['error' => true, 'message' => 'Supplier Purchase Order not Found'], 422);
                }
            }catch(Exception $e){
                Session::flash('error', 'Supplier Purchase Order not Found');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }


}
