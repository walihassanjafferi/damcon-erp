<?php

namespace App\Http\Controllers\User\paymentsmanagement;

use App\Http\Requests\BankPaymentsManagementRequest;
use App\Models\Bankaccounts;
use App\Models\BatchPaymentsManagement;
use App\Models\BankPayments;
use App\Models\categories;
use App\Models\Project;
use App\Traits\FileAttachmentsTrait as FileUploader;
use App\Traits\ProjectTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\BankTransactionTrait;
use App\Models\ErpCategories;
use Session;
use DataTables;
use DB;
class BankPaymentsController extends Controller
{
    private $path    = 'user.paymentmanagement.bankpayments';
    private $authR   = 'bank_payments_management_modules';
    private $folderN = 'bankpayments';
    private $fileN   = 'B_P';

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

                $data = BankPayments::orderby('id','desc')->get();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $actionBtn = '<a href="'.route('bank_payment_management.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                                      <a href="'.route('bank_payment_management.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;
                                      <a  onclick="deleteOrder('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>';
                        return $actionBtn;
                    })->addColumn('project',function($row){
                        return $row->projects->name;
                    })->addColumn('checkbox',function($row){
                        $checkBtn = '<input type="checkbox" class="order_check"  value="'.$row->id.'">';
                        return $checkBtn;
                    })
                    ->addColumn('amount',function($row){
                        return number_format($row->amount);
                    })
                    ->rawColumns(['action','checkbox','project','amount'])
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
            $projects          = Project::pluck('name','id')->toArray();
            // $categories        = categories::where(['module_id'=>15,'id'=>9])->first();
            // $categories        = $categories->childCatgories->pluck('name','id')->toArray();

            $categories = DB::table('erp_categories as a')->where('a.module_name','bank_payments')->get();
            $bankaccounts      = Bankaccounts::get(['name','id','title']);
            $batches_payment   = BatchPaymentsManagement::get(['id','title','amount','bank_of_batch']);
            return view($this->path.'.create',compact('projects','categories','bankaccounts','batches_payment'));
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
    public function store(BankPaymentsManagementRequest $r)
    {
       
        if(Auth::user()->can($this->authR))
        {
            try {
                DB::beginTransaction();

                $amount = (float)str_replace(',', '', $r->amount);
                $bank = Bankaccounts::find($r->bank_id);

                if($amount > $bank->avaliable_funds)
                {
                    Session::flash('warning',$bank->name. " has insufficient balance!");
                    return redirect()->back()->withInput();
                }

                $bank_payments                           = new BankPayments();
                $bank_payments->user_id                  = Auth::id();
                $bank_payments->project_id               = $r->project_id;
                $bank_payments->expense_type             = $r->expense_type;
                $bank_payments->payment_type             = $r->payment_type;
                $bank_payments->payment_date             = $r->payment_date;
                $bank_payments->region                   = $r->region;
                $bank_payments->amount                   = $amount;
                $bank_payments->paid_to_person           = $r->paid_to_person;
                $bank_payments->comments                 = $r->comments;

                if($r->payment_type == "advance"){

                    $bank_payments->batch_id             = $r->batch_id;
                    $bank_payments->bank_id              = $r->bank_id;


                }elseif ($r->payment_type =="bank"){
                    $bank_payments->cheque_number        = $r->cheque_number;
                    $bank_payments->bank_id              = $r->bank_id;
                }


                $image_names=[];

                //Upload Files
                if($r->hasfile('document_file'))
                {
                    foreach($r->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,$this->folderN,$this->fileN);
                        array_push($image_names,$filename);
                    }
                    $bank_payments->document_file  = json_encode($image_names);
                }

                //Save Files
                if($bank_payments->save())
                {

                    // Handling bank amount

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
                        'Bank Payment',
                        $amount, //withdraw amount
                        0, //deposit amount
                        $r->comments, //comments
                        '', //title,
                        $bank_payments->payment_date 
                    );
                    
                    // Handling bank amount

                    // handling project ADVANCES
                    if($r->payment_type == "advance")
                    {
                        ProjectTrait::ProjectAdvances(
                            $r->expense_type_name,
                            $user_id,
                            $bank_payments->project_id,
                            "Bank Payment Expense",
                            $bank_payments->id,
                            $r->expense_type_name,
                            $amount,
                            $r->comments
                        );
                    }
                    

                    DB::commit();
                    Session::flash('created', 'Bank Payments Added Successfully');
                    return redirect()->route('bank_payment_management.index');
                }
                else{
                    Session::flash('error', 'Error adding Bank Payments');
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
     * @param  \App\Models\BankPayments  $cashPayments
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $bank_payments     = BankPayments::find(decrypt($id));
            return view($this->path.'.view',compact('bank_payments'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankPayments  $cashPayments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $projects          = Project::pluck('name','id')->toArray();
            // $categories        = categories::where(['module_id'=>15,'id'=>9])->first();
            // $categories        = $categories->childCatgories->pluck('name','id')->toArray();
            $categories = DB::table('erp_categories as a')->where('a.module_name','bank_payments')->get();
            $bankaccounts      = Bankaccounts::get(['name','id','title']);
            $batches_payment   = BatchPaymentsManagement::get(['id','title']);
            $bank_payments     = BankPayments::find(decrypt($id));
            return view($this->path.'.edit',compact('projects','categories','bankaccounts','batches_payment','bank_payments'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankPayments  $cashPayments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        if(Auth::user()->can($this->authR))
        {
            $id  = decrypt($id);
            try {
                $bank_payments                           = BankPayments::find($id);
                $bank_payments->project_id               = $r->project_id;
                $bank_payments->expense_type             = $r->expense_type;
                $bank_payments->payment_type             = $r->payment_type;
                $bank_payments->payment_date             = $r->payment_date;
                $bank_payments->region                   = $r->region;
                $bank_payments->amount                   = $r->amount;
                $bank_payments->paid_to_person           = $r->paid_to_person;
                $bank_payments->comments                 = $r->comments;

                if($r->payment_type == "advance"){

                    $bank_payments->batch_id             = $r->batch_id;
                    $bank_payments->cheque_number        = null;
                    $bank_payments->bank_id              = null;

                }elseif ($r->payment_type =="bank"){

                    $bank_payments->cheque_number        = $r->cheque_number;
                    $bank_payments->bank_id              = $r->bank_id;
                    $bank_payments->batch_id             = null;
                }

                $images                                  = json_decode($bank_payments->document_file);

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

                if($bank_payments->document_file !=null){
                    foreach($images as $img)
                    {
                        if (!in_array($img,$remove_images)) {
                            array_push($new_images,$img);
                        }
                    }
                }
                $bank_payments->document_file = $new_images;

                //Save Files
                if($bank_payments->update())
                {
                    // saving items
                    Session::flash('created', 'Bank Payments Updated Successfully');
                    return redirect()->route('bank_payment_management.index');
                }
                else{
                    Session::flash('error', 'Error updating Bank Payments');
                    return redirect()->back()->withInput();
                }
            }catch(Exception $e){
                Session::flash('error', 'Error updating Bank Payments');
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
     * @param  \App\Models\BankPayments  $cashPayments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if(Auth::user()->can($this->authR))
        {
            try {
                $id = $request->id;
                $bank_payments = BankPayments::find($id);
                if($bank_payments)
                {
                    if($bank_payments->document_file !=null){
                        foreach(json_decode($bank_payments->document_file) as $img)
                        {
                            FileUploader::RemoveFile($img,$this->folderN);
                        }
                    }
                    $bank_payments->delete();
                    return response()->json(['success' => true, 'message' => 'Bank Payments deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Bank Payments deletion failed'], 422);
                }
            }
            catch(Exception $e){
                Session::flash('error', 'Bank Payments not Deleted');
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

                BankPayments::find($orderList)->each(function ($bank_payments) {
                    if($bank_payments)
                    {
                        if($bank_payments->document_file !=null){
                            foreach(json_decode($bank_payments->document_file) as $img)
                            {
                                FileUploader::RemoveFile($img,$this->folderN);
                            }
                        }
                        $bank_payments->delete();
                    }
                    else{
                        return response()->json(['error' => true, 'message' => 'Bank Payments deletion failed'], 422);
                    }
                });
                return response()->json(['success' => true, 'message' => 'Bank Payments deleted Successfully'], 200);

            }catch(Exception $e){
                Session::flash('error', 'Bank Payments not Deleted');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }
}
