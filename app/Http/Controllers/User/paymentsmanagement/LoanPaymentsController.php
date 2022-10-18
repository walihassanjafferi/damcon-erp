<?php

namespace App\Http\Controllers\User\paymentsmanagement;

use App\Models\Bankaccounts;
use App\Models\Investors;
use App\Models\LoanPayments;
use App\Models\Project;
use App\Traits\FileAttachmentsTrait as FileUploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\InvestorLedgerTrait;
use App\Traits\BankTransactionTrait;
use Session;
use DataTables;
use DB;

class LoanPaymentsController extends Controller
{
    private $path    = 'user.paymentmanagement.loanpayments';
    private $authR   = 'loan_payments_management_modules';
    private $folderN = 'loan_payments';
    private $fileN   = 'L_P';

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

                $data = LoanPayments::orderby('id','desc')->get(['id','title','investor_id','project_id','bank_id','date','amount','payment_type']);

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $actionBtn = '<a href="'.route('loan_payment_management.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                                      <a href="'.route('loan_payment_management.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;
                                      <a  onclick="deleteOrder('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>';
                        return $actionBtn;
                    })->addColumn('project',function($row){
                        return $row->project->name ?? '';
                    })->addColumn('bank_name',function($row){
                        return $row->banks->name.'('.$row->banks->title.')';
                    })->addColumn('investor_name',function($row){
                        return $row->investor->name;
                    })->addColumn('checkbox',function($row){
                        $checkBtn = '<input type="checkbox" class="order_check"  value="'.$row->id.'">';
                        return $checkBtn;
                    })
                    ->addColumn('amount',function($row){
                        return number_format($row->amount);
                    })
                    ->rawColumns(['action','checkbox','project','banks','investor','amount'])
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
            $investors = Investors::get(['name','id']);

            // $investors = DB::table('investors as i')->join('investor_ledgers as ledger','ledger.id','i.id')->select(DB::raw('SUM(ledger.investor_balance) AS balance'),'i.id','i.name')->get();
            // dd( $investors);
            $bank_accounts          = Bankaccounts::get(['name','id','title']);
            $projects               = Project::get(['name','id']);
            

            return view($this->path.'.create',compact('bank_accounts','projects','investors'));
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



                ##checking bank balance
                if($r->payment == 'out')
                {
                    $bank = Bankaccounts::find($r->bank_id);
                    if($amount >= $bank->avaliable_funds)
                    {
                        Session::flash('error','Selected Bank '.$bank->name.' ('.$bank->title.') '.'has not sufficient Balance!');
                        return redirect()->back()->withInput();
                    }
                }


                $loan_payments                       = new LoanPayments();
                $loan_payments->user_id              = Auth::id();
                $loan_payments->title                = $r->title;
                $loan_payments->investor_id          = $r->investor_id;
                $loan_payments->payment_type         = $r->payment_type;
                $loan_payments->project_id           = $r->project_id;
                $loan_payments->bank_id              = $r->bank_id;
                $loan_payments->cheque_title         = $r->cheque_title;
                $loan_payments->cheque_number        = $r->cheque_number;
                $loan_payments->date                 = $r->date;
                $loan_payments->amount               = $amount;
                $loan_payments->payment_details      = $r->payment_details;
                $loan_payments->comments             = $r->comments;
                $loan_payments->payment             = $r->payment;


                $image_names=[];

                //Upload Files
                if($r->hasfile('document_file'))
                {
                    foreach($r->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,$this->folderN,$this->fileN);
                        array_push($image_names,$filename);
                    }
                    $loan_payments->document_file  = json_encode($image_names);
                }

                //Save Files
                if($loan_payments->save())
                {
                    $loan_payments->refresh();

                    if($loan_payments->payment == 'out')
                    {
                        ##adding bank transaction
                        $bank = Bankaccounts::find($loan_payments->bank_id);
                        $bank->current_balance = $bank->current_balance - $loan_payments->amount;
                        $bank->avaliable_funds =  $bank->avaliable_funds - $loan_payments->amount;
                        if($bank->save())
                        {   
                            $bank->refresh();
                            $user_id = Auth()->user()->id;
                        
                            
                            $transaction_log = BankTransactionTrait::logTransaction(
                                $bank->id,
                                $user_id,
                                $loan_payments->amount,
                                'debited',
                                $bank->avaliable_funds,
                                'Investor Principal Payment Out',
                                $loan_payments->amount, //withdraw amount
                                0, //deposit amount
                                $r->comments, //comments
                                $r->title, //title
                                $loan_payments->date

                            );
                        
                        
                        }
                        ##adding bank transaction
                    }
                    else if($loan_payments->payment == 'in')
                    {
                           ##adding bank transaction
                           $bank = Bankaccounts::find($loan_payments->bank_id);
                           $bank->current_balance = $bank->current_balance + $loan_payments->amount;
                           $bank->avaliable_funds =  $bank->avaliable_funds + $loan_payments->amount;
                           if($bank->save())
                           {   
                               $bank->refresh();
                               $user_id = Auth()->user()->id;
                           
                               
                               $transaction_log = BankTransactionTrait::logTransaction(
                                   $bank->id,
                                   $user_id,
                                   $loan_payments->amount,
                                   'credited',
                                   $bank->avaliable_funds,
                                   'Investor Principal payment In',
                                   $loan_payments->amount, //withdraw amount
                                   0, //deposit amount
                                   $r->comments, //comments
                                   $r->title, //title
                                   $loan_payments->date
                               );
                           
                           
                           }
                           ##adding bank transaction
                    }
             

                    ##Investor ledger payment
                    InvestorLedgerTrait::add_investor_ledger(
                        $loan_payments->title,
                        $loan_payments->investor_id,
                        $loan_payments->payment == 'in' ? 'payment_in' : 'payment_out',
                        $loan_payments->amount,
                        $r->project_id
                    );
                    ##Investor ledger payment
                    
                    
                    DB::commit();
                    Session::flash('created', 'Investor Principal Payments Added Successfully');

                    return redirect()->route('loan_payment_management.index');
                }
                else{

                    Session::flash('error', 'Error adding Investor Principal Payments');
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
     * @param  \App\Models\LoanPayments  $loanPayments
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $loan_payments          = LoanPayments::find(decrypt($id));
            return view($this->path.'.view',compact('loan_payments'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanPayments  $loanPayments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $investors              = Investors::get(['name','id']);
            $bank_accounts          = Bankaccounts::get(['name','id','title']);
            $projects               = Project::get(['name','id']);
            $loan_payments          = LoanPayments::find(decrypt($id));

            return view($this->path.'.edit',compact('bank_accounts','projects','investors','loan_payments'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoanPayments  $loanPayments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        if(Auth::user()->can($this->authR))
        {
            $id  = decrypt($id);
            try {
                $loan_payments                       = LoanPayments::find($id);
                $loan_payments->title                = $r->title;
                $loan_payments->investor_id          = $r->investor_id;
                $loan_payments->payment_type         = $r->payment_type;
                $loan_payments->project_id           = $r->project_id;
                $loan_payments->bank_id              = $r->bank_id;
                $loan_payments->cheque_title         = $r->cheque_title;
                $loan_payments->cheque_number        = $r->cheque_number;
                $loan_payments->date                 = $r->date;
                $loan_payments->amount               = $r->amount;
                $loan_payments->payment_details      = $r->payment_details;
                $loan_payments->comments             = $r->comments;
                $loan_payments->payment             = $r->payment;


                $images                              = json_decode($loan_payments->document_file);

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

                if($loan_payments->document_file !=null){
                    foreach($images as $img)
                    {
                        if (!in_array($img,$remove_images)) {
                            array_push($new_images,$img);
                        }
                    }
                }
                $loan_payments->document_file = $new_images;

                //Save Files
                if($loan_payments->update())
                {
                    // saving items
                    Session::flash('created', 'Investor Principal Payments Updated Successfully');
                    return redirect()->route('loan_payment_management.index');
                }
                else{
                    Session::flash('error', 'Error updating Loan Payments');
                    return redirect()->back()->withInput();
                }
            }catch(Exception $e){
                Session::flash('error', $e->getMessage());
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
     * @param  \App\Models\LoanPayments  $loanPayments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if(Auth::user()->can($this->authR))
        {
            try {
                $id = $request->id;
                $loan_payments = LoanPayments::find($id);
                if($loan_payments)
                {
                    if($loan_payments->document_file !=null){
                        foreach(json_decode($loan_payments->document_file) as $img)
                        {
                            FileUploader::RemoveFile($img,$this->folderN);
                        }
                    }
                    $loan_payments->delete();
                    return response()->json(['success' => true, 'message' => 'Loan Payments deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Loan Payments deletion failed'], 422);
                }
            }
            catch(Exception $e){
                Session::flash('error', 'Loan Payments not Deleted');
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

                LoanPayments::find($orderList)->each(function ($loan_payments) {
                    if($loan_payments)
                    {
                        if($loan_payments->document_file !=null){
                            foreach(json_decode($loan_payments->document_file) as $img)
                            {
                                FileUploader::RemoveFile($img,$this->folderN);
                            }
                        }
                        $loan_payments->delete();
                    }
                    else{
                        return response()->json(['error' => true, 'message' => 'Loan Payments deletion failed'], 422);
                    }
                });
                return response()->json(['success' => true, 'message' => 'Loan Payments deleted Successfully'], 200);

            }catch(Exception $e){
                Session::flash('error', 'Loan Payments not Deleted');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }


}
