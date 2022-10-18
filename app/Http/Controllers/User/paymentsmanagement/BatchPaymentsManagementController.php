<?php

namespace App\Http\Controllers\User\paymentsmanagement;

use App\Http\Requests\BatchPaymentsManagementRequest;
use App\Models\Bankaccounts;
use App\Models\BatchesManagement;
use App\Models\BatchPaymentsManagement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\BankTransactionTrait;
use App\Models\Batch_management_logs;
// models for batches
use App\Models\SalariesManagement;
use App\Models\AdvanceHrPayment;
use App\Models\SupplierPayments;
// models for batches
use Session;
use DataTables;
use DB;


class BatchPaymentsManagementController extends Controller
{
    private $path    = 'user.paymentmanagement.batchpaymentsmanagement';
    private $authR   = 'batches_payments_management_modules';

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

                $data = BatchPaymentsManagement::orderby('id','desc')->get();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $actionBtn = '<a href="'.route('batches_payment_management.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                                      <a href="'.route('batches_payment_management.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;
                                      <a  onclick="deleteOrder('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>';
                        return $actionBtn;
                    })->addColumn('batches_name',function($row){
                        return $row->batches->name_of_batch;
                    })->addColumn('bank_name',function($row){
                        return $row->banks->name.'('.$row->banks->title.')';
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
            $batches = BatchesManagement::where('status','unpaid')->get(['name_of_batch','id']);
            return view($this->path.'.create',compact('batches'));
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
    public function store(BatchPaymentsManagementRequest $request)
    {
        if(Auth::user()->can($this->authR))
        {
            try {

                DB::beginTransaction();

                $batch_id = $request->batch_id;
                
                $batch = BatchesManagement::find($request->batch_id);
                $batch->status = 'paid';
                $batch->save();

                // check bank account balance
                $amount = $request->amount;
                $bank = Bankaccounts::find($batch->banks->id);

                if($amount > $bank->avaliable_funds)
                {
                    Session::flash('warning',$batch->banks->name. " has Insufficient balance!");
                    return redirect()->back()->withInput();
                }


                $batches_payment                     = new BatchPaymentsManagement();
                $batches_payment->user_id            = Auth::id();
                $batches_payment->title              = $request->title;
                $batches_payment->batch_id           = $request->batch_id;
                $batches_payment->date_of_cheque     = $request->date_of_cheque;
                $batches_payment->bank_of_batch      = $batch->banks->id;
                $batches_payment->amount             = $amount;
                $batches_payment->cheque_title       = $request->cheque_title;
                $batches_payment->cheque_number      = $request->cheque_number;
                $batches_payment->batch_description  = $request->batch_description;
                $batches_payment->comment_box        = $request->comment_box;


                if($batches_payment->save())
                {
                    // deducting amount from bank

                    $bank->current_balance =  $bank->current_balance - $amount;
                    $bank->avaliable_funds =  $bank->avaliable_funds - $amount;
                    $bank->save();

                    $user_id = Auth()->user()->id;

                    $transaction_log = BankTransactionTrait::logTransaction(
                        $bank->id,
                        $user_id,
                        $amount,
                        'debited',
                        $bank->avaliable_funds,
                        'Batch Payment',
                        $amount, //withdraw amount
                        0, //deposit amount
                        '',
                        $request->title, //title
                        $batches_payment->date_of_cheque
                    );


                    // changing invoices status

                    $advanceHr_ids = Batch_management_logs::where('batch_id',$batch_id)->where('invoice_type','advanceHr_management')->pluck('invoice_id');
                    $salaries_ids = Batch_management_logs::where('batch_id',$batch_id)->where('invoice_type','salaries_management')->pluck('invoice_id');
                    $supplier_ids = Batch_management_logs::where('batch_id',$batch_id)->where('invoice_type','supplier_payments')->pluck('invoice_id');


                    $salaries = SalariesManagement::whereIn('id',$salaries_ids)->update(['batch_status'=>1]);
                    $advanceHr = AdvanceHrPayment::whereIn('id',$advanceHr_ids)->update(['batch_status'=>1]);
                    $supplier_payment = SupplierPayments::whereIn('id',$supplier_ids)->update(['batch_status'=>1]);



                    // changing invoices status


                    DB::commit();

                    Session::flash('created', 'Batches Payment Added Successfully');
                    return redirect()->route('batches_payment_management.index');
                }
                else{

                    Session::flash('error', 'Error adding Batches Payment');
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
     * @param  \App\Models\BatchPaymentsManagement  $batchPaymentsManagement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $id = decrypt($id);
            $batches_payments = BatchPaymentsManagement::find($id);
            return view($this->path.'.view',compact('batches_payments'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BatchPaymentsManagement  $batchPaymentsManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $id = decrypt($id);
            $batches_payments = BatchPaymentsManagement::find($id);
            $batches = BatchesManagement::get(['name_of_batch','id']);
            return view($this->path.'.edit',compact('batches','batches_payments'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BatchPaymentsManagement  $batchPaymentsManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
        if(Auth::user()->can($this->authR))
        {
            try {
                $batch = BatchesManagement::find($request->batch_id);
                $batches_payment                     = BatchPaymentsManagement::find(decrypt($id));
                $batches_payment->title              = $request->title;
                $batches_payment->batch_id           = $request->batch_id;
                $batches_payment->date_of_cheque     = $request->date_of_cheque;
                $batches_payment->bank_of_batch      = $batch->banks->id;
                $batches_payment->amount             = $request->amount;
                $batches_payment->cheque_title       = $request->cheque_title;
                $batches_payment->cheque_number      = $request->cheque_number;
                $batches_payment->batch_description  = $request->batch_description;
                $batches_payment->comment_box        = $request->comment_box;

                if($batches_payment->update())
                {
                    Session::flash('created', 'Batches Payment Updated Successfully');
                    return redirect()->route('batches_payment_management.index');
                }
                else{

                    Session::flash('error', 'Error Updating Batches Payment');
                    return redirect()->back()->withInput();
                }

            }catch(Exception $e){
                Session::flash('error', 'Error Updating Batches Payment');
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
     * @param  \App\Models\BatchPaymentsManagement  $batchPaymentsManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {

        if(Auth::user()->can($this->authR))
        {
            try {
                $id = $request->id;
                $batches_payments = BatchPaymentsManagement::find($id);
                if($batches_payments)
                {
                    $batches_payments->delete();
                    return response()->json(['success' => true, 'message' => 'Batches Payment deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Batches Payment deletion failed'], 422);
                }
            }
            catch(Exception $e){
                Session::flash('error', 'Batches Payment not Deleted');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }


    public function getBank(Request $request){
        if(Auth::user()->can($this->authR))
        {
            $id = $request->id;
            $batch = BatchesManagement::find($id);

            if($batch)
            {
                return response()->json(['success' => true, 'message' => $batch->bank_id,'name'=>$batch->banks->name.'('.$batch->banks->title.')','amount'=>$batch->amount], 200);
            }
            else{
                return response()->json(['error' => true, 'message' =>" Batch not found"], 404);

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

                BatchPaymentsManagement::find($orderList)->each(function ($batches_payments) {
                    if($batches_payments)
                    {
                        $batches_payments->delete();
                    }
                    else{
                        return response()->json(['error' => true, 'message' => 'Batches Payment deletion failed'], 422);
                    }
                });
                return response()->json(['success' => true, 'message' => 'Batches Payment deleted Successfully'], 200);

            }catch(Exception $e){
                Session::flash('error', 'Batches Payment not Deleted');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }
}
