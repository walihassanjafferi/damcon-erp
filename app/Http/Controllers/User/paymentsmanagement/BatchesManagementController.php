<?php

namespace App\Http\Controllers\User\paymentsmanagement;

use App\Models\Bankaccounts;
use App\Models\BatchesManagement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\SupplierPayments;
use App\Models\SecurityPayments;
use App\Models\LoanPayments;
// Invoice logs in batch model
use App\Models\Batch_management_logs;

// models for batches
use App\Models\SalariesManagement;
use App\Models\AdvanceHrPayment;

// models for batches

use Carbon\Carbon;
use Session;
use DataTables;
use DB;


class BatchesManagementController extends Controller
{
    private $path    = 'user.paymentmanagement.batchesmanagement';
    private $authR   = 'batches_management_modules';

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

                $data = BatchesManagement::orderby('id','desc')->get();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $actionBtn = '<a href="'.route('batches_management.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                                      <a href="'.route('batches_management.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;
                                      <a  onclick="deleteOrder('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>';
                        return $actionBtn;
                    })->addColumn('bank_name',function($row){
                        return $row->banks->name.'('.$row->banks->title.')';
                    })->addColumn('checkbox',function($row){
                        $checkBtn = '<input type="checkbox" class="order_check"  value="'.$row->id.'">';
                        return $checkBtn;
                    })
                    ->rawColumns(['action','checkbox'])
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
        $payment_method = 'batch';
        if(Auth::user()->can($this->authR))
        {
            $bankaccounts = Bankaccounts::get(['name','id','title']);


            $salaries = SalariesManagement::where('payment_method',$payment_method)->where('batch_added',0)->where('batch_status',0)->get();
            $advanceHr = AdvanceHrPayment::where('payment_mode',$payment_method)->where('batch_added',0)->where('batch_status',0)->get();
            $supplier_payment = SupplierPayments::where('payment_method',$payment_method)->where('batch_added',0)->where('batch_status',0)->get();
            $security_payment = SecurityPayments::where('payment_method',$payment_method)->where('batch_added',0)->where('batch_status',0)->get();

            return view($this->path.'.create',compact('bankaccounts','salaries','advanceHr','supplier_payment','security_payment'));
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

        DB::beginTransaction();
        if(Auth::user()->can($this->authR))
        {
            try {

                $salariesids = []; $advancehrids = []; $supplierpaymentids = [];

                ##unique batch title

                $check_batch_title = BatchesManagement::where('name_of_batch',$request->name_of_batch)->first();

                if($check_batch_title)
                {
                    Session::flash('warning','Duplication Name of Batch!');
                    return redirect()->back()->withInput();
                }

                ##unique bathc title
            

                $amount = (float)str_replace(',', '', $request->amount);
                //dd($amount);

                $batches_man                             = new BatchesManagement();
                $batches_man->user_id                    = Auth::id();
                $batches_man->name_of_batch              = $request->name_of_batch;
                $batches_man->bank_id                    = $request->bank_id;
                $batches_man->date_of_creation           = $request->date_of_creation;
                $batches_man->description_input          = $request->description_input;
                $batches_man->amount                     = $amount;
              
                if($batches_man->save())
                {   

                    // Adding Invoice logs in batch
                   
                    if($request->has('salariesids'))
                    {
                        $salaries_batch_log = [];

                        $salariesids = array_map('intval', $request->salariesids);
                        // updating batch salaries
                        $salaries = SalariesManagement::whereIn('id',$salariesids)->update(['batch_added'=>1]);

                        // making log for salary batch
                        foreach($salariesids as $val)
                        {
                            $log = [
                                'batch_id' => $batches_man->id,
                                'invoice_type' => 'salaries_management',
                                'invoice_id' => $val,
                                'batch_status'=> 'unpaid',
                                'created_at'=> Carbon::now(),
                                'updated_at'=> Carbon::now(),
                            ];

                            array_push($salaries_batch_log,$log);

                            $log = [];
                        }
                        $batch_invoices_log = Batch_management_logs::insert($salaries_batch_log);

                    }

                    if($request->has('advancehrids'))
                    {

                        $advancehr_batch_log = [];

                        $advancehrids = array_map('intval', $request->advancehrids);
                        // updating batch advance Hr
                        $advanceHr = AdvanceHrPayment::whereIn('id',$advancehrids)->update(['batch_added'=>1]);

                        
                        // making log for AdvanceHR batch
                        foreach($advancehrids as $val)
                        {
                            $log = [
                                'batch_id' => $batches_man->id,
                                'invoice_type' => 'advanceHr_management',
                                'invoice_id' => $val,
                                'batch_status'=> 'unpaid',
                                'created_at'=> Carbon::now(),
                                'updated_at'=> Carbon::now(),
                            ];

                            array_push($advancehr_batch_log,$log);

                            $log = [];
                        }


                        $batch_invoices_log = Batch_management_logs::insert($advancehr_batch_log);

                    }


                    if($request->has('supplierpaymentids'))
                    {

                        $supplierpayment_batch_log = [];

                        $supplierpaymentids = array_map('intval', $request->supplierpaymentids);
                        // updating batch advance Hr
                        $supplierpayments = SupplierPayments::whereIn('id',$supplierpaymentids)->update(['batch_added'=>1]);

                        // making log for AdvanceHR batch
                        foreach($supplierpaymentids as $val)
                        {
                            $log = [
                                'batch_id' => $batches_man->id,
                                'invoice_type' => 'supplier_payments',
                                'invoice_id' => $val,
                                'batch_status'=> 'unpaid',
                                'created_at'=> Carbon::now(),
                                'updated_at'=> Carbon::now(),
                            ];

                            array_push($advancehr_batch_log,$log);

                            $log = [];
                        }
                        $batch_invoices_log = Batch_management_logs::insert($advancehr_batch_log);


                    }

                    if($request->has('securitypaymentids'))
                    {

                        $securitypayment_batch_log = [];

                        $securitypaymentids = array_map('intval', $request->securitypaymentids);
                        // updating batch advance Hr
                        $securitypayments = SecurityPayments::whereIn('id',$securitypaymentids)->update(['batch_added'=>1]);

                        // making log for AdvanceHR batch
                        foreach($securitypaymentids as $val)
                        {
                            $log = [
                                'batch_id' => $batches_man->id,
                                'invoice_type' => 'security_payments',
                                'invoice_id' => $val,
                                'batch_status'=> 'unpaid',
                                'created_at'=> Carbon::now(),
                                'updated_at'=> Carbon::now(),
                            ];

                            array_push($securitypayment_batch_log,$log);

                            $log = [];
                        }
                        $batch_invoices_log = Batch_management_logs::insert($securitypayment_batch_log);

                    }


                    DB::commit();


                    Session::flash('created', 'Batches Added Successfully');
                    return redirect()->route('batches_management.index');
                }
                else{

                    Session::flash('error', 'Error adding Batches');
                    return redirect()->back()->withInput();
                }

            }catch(Exception $e){
                DB::rollback();
                Session::flash('error', 'Error adding Batches');
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
     * @param  \App\Models\BatchesManagement  $batchesManagement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $id           = decrypt($id);
            $batche       = BatchesManagement::find($id);
            return view($this->path.'.view',compact('batche'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BatchesManagement  $batchesManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if(Auth::user()->can($this->authR))
        {
            $payment_method = 'batch';

            $id           = decrypt($id);
            $batche       = BatchesManagement::find($id);
            $bankaccounts = Bankaccounts::get(['name','id','title']);

            // getting batch invoices
            
            
            $advanceHr_ids = Batch_management_logs::where('batch_id',$id)->where('invoice_type','advanceHr_management')->pluck('invoice_id');
            $salaries_ids = Batch_management_logs::where('batch_id',$id)->where('invoice_type','salaries_management')->pluck('invoice_id');
            $supplier_ids = Batch_management_logs::where('batch_id',$id)->where('invoice_type','supplier_payments')->pluck('invoice_id');
            $security_ids = Batch_management_logs::where('batch_id',$id)->where('invoice_type','security_payments')->pluck('invoice_id');
        

            $salaries = SalariesManagement::whereIn('id',$salaries_ids)->get();
            $advanceHr = AdvanceHrPayment::whereIn('id',$advanceHr_ids)->get();
            $supplier_payment = SupplierPayments::whereIn('id',$supplier_ids)->get();
            $security_payment = SecurityPayments::whereIn('id',$security_ids)->get();


            // getting batch invoices


            return view($this->path.'.edit',compact('bankaccounts','batche','salaries','advanceHr','supplier_payment','security_payment'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BatchesManagement  $batchesManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can($this->authR))
        {
            try {
                $id                                      = decrypt($id);
                $batches_man                             = BatchesManagement::find($id);
                $batches_man->name_of_batch              = $request->name_of_batch;
                $batches_man->bank_id                    = $request->bank_id;
                $batches_man->date_of_creation           = $request->date_of_creation;
                $batches_man->description_input          = $request->description_input;
                $batches_man->amount                     = $request->amount;

                if($batches_man->Update())
                {
                    Session::flash('created', 'Batches Updated Successfully');
                    return redirect()->route('batches_management.index');
                }
                else{

                    Session::flash('error', 'Error updating Batches');
                    return redirect()->back()->withInput();
                }

            }catch(Exception $e){
                Session::flash('error', 'Error updating Batches');
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
     * @param  \App\Models\BatchesManagement  $batchesManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {

        if(Auth::user()->can($this->authR))
        {
            try {
                $id = $request->id;
                $batches_man = BatchesManagement::find($id);
                if($batches_man)
                {
                    $batches_man->delete();
                    return response()->json(['success' => true, 'message' => 'Batches deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Batches deletion failed'], 422);
                }
            }
            catch(Exception $e){
                Session::flash('error', 'Batches not Deleted');
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

                BatchesManagement::find($orderList)->each(function ($batches_man) {
                    if($batches_man)
                    {
                        $batches_man->delete();
                    }
                    else{
                        return response()->json(['error' => true, 'message' => 'Batches deletion failed'], 422);
                    }
                });
                return response()->json(['success' => true, 'message' => 'Batches deleted Successfully'], 200);

            }catch(Exception $e){
                Session::flash('error', 'Batches not Deleted');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }
}
