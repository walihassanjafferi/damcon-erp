<?php

namespace App\Http\Controllers\User\paymentsmanagement;

use App\Http\Requests\SecurityPaymentRequest;
use App\Models\Bankaccounts;
use App\Models\chidcategories;
use App\Models\categories;
use App\Models\Project;
use App\Models\SecurityPayments;
use App\Models\Customer;
use App\Traits\FileAttachmentsTrait as FileUploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\BankTransactionTrait;
use App\Models\BatchPaymentsManagement;
use App\Models\ErpCategories;
use Session;
use DataTables;
use DB;

class SecurityPaymentsController extends Controller
{
    private $path    = 'user.paymentmanagement.securitypayments';
    private $authR   = 'security_payments_management_modules';
    private $folderN = 'security_payments';
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

                $data = SecurityPayments::orderby('id','desc')->get(['id','project_id','bank_id','date','amount','payment_type','title']);

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $actionBtn = '<a href="'.route('security_payment_management.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                                      <a href="'.route('security_payment_management.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;';
                                    //   <a  onclick="deleteOrder('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>';
                        return $actionBtn;

                    })->addColumn('title',function($row){
                            return $row->title;
                        
                    })->addColumn('project',function($row){
                        return $row->project->name;
                    })->addColumn('bank_name',function($row){
                        if(isset($row->banks)){return $row->banks->name.'('.$row->banks->title.')'; } 
                    })->addColumn('payment_type',function($row){
                        return $row->paymenttype->name;
                    })->addColumn('checkbox',function($row){
                        $checkBtn = '<input type="checkbox" class="order_check"  value="'.$row->id.'">';
                        return $checkBtn;
                    })
                    ->rawColumns(['action','checkbox','title','project','banks','payment_type'])
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
            $projects               = Project::get(['name','id']);
            // $category               = categories::where('module_id',17)->get(['name','id']);
            $categories = DB::table('erp_categories as a')->where('a.module_name','security_bid_bond')->get();
            $customer               = Customer::get(['id','name','zip_code']);
            $batches_payment   = BatchPaymentsManagement::get(['id','title','amount','bank_of_batch']);


            return view($this->path.'.create',compact('bank_accounts','projects','categories','customer','batches_payment'));
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
    public function store(Request  $r)
    {   
        
        DB::beginTransaction();
        if(Auth::user()->can($this->authR))
        {
            try {

                $amount = (float)str_replace(',', '', $r->amount);


                $bank = Bankaccounts::find($r->bank_id);
                
                if($amount > $bank->avaliable_funds)
                {
                    Session::flash('error','Selected Bank '.$bank->name.' ('.$bank->title.') '.'has not sufficient Balance!');
                    return redirect()->back()->withInput();
                }

                $security_payments                          = new SecurityPayments();
                $security_payments->user_id                 = Auth::id();
                $security_payments->project_id              = $r->project_id;
                $security_payments->title                   = $r->title;
                $security_payments->payment_type            = $r->payment_type;
                $security_payments->payment_method          = $r->payment_method;
                if($r->has('bank_id'))
                {
                    $security_payments->bank_id                 = $r->bank_id;
                }
                if($r->has('cheque_title'))
                {
                    $security_payments->cheque_title            = $r->cheque_title;
                }

                if($r->has('cheque_number'))
                {
                    $security_payments->cheque_number           = $r->cheque_number;
                }

                $security_payments->date                    = $r->date;
                $security_payments->amount                  = $amount;
                $security_payments->payment_details         = $r->payment_details;
                $security_payments->customer                = $r->customer;
                $security_payments->comments                = $r->comments;
                $security_payments->customer_id             = $r->customer_id;

                // if($r->payment_method == 2)
                // {
                //     $security_payments->batch_id = $r->batch_id;
                // }

                $image_names=[];

                //Upload Files
                if($r->hasfile('document_file'))
                {
                    foreach($r->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,$this->folderN,$this->fileN);
                        array_push($image_names,$filename);
                    }
                    $security_payments->document_file  = json_encode($image_names);
                }

                //Save Files
                if($security_payments->save())
                {

                    if($r->has('bank_id') && $r->payment_method == 'direct') 
                    {
                        ##depositing cheque in bank
                      //  $bank = Bankaccounts::find($security_payments->bank_id);
                        $bank->current_balance = $bank->current_balance - $security_payments->amount;
                        $bank->avaliable_funds =  $bank->avaliable_funds - $security_payments->amount;
                        if($bank->save())
                        {   
                            $bank->refresh();
                            $user_id = Auth()->user()->id;
                            $transaction_log = BankTransactionTrait::logTransaction(
                                $bank->id,
                                $user_id,
                                $security_payments->amount,
                                'debited',
                                $bank->avaliable_funds,
                                'Security Bid Bond Payment',
                                0,
                                $security_payments->amount,
                                $security_payments->comments,
                                '',
                                $security_payments->date 
                                );
                        }
                        ##depositing cheque in bank
                    }

                    DB::commit();

                    Session::flash('created', 'Security Payments Added Successfully');

                    return redirect()->route('security_payment_management.index');
                }
                else{
                    DB::rollback();
                    Session::flash('error', 'Error adding Security Payments');
                    return redirect()->back()->withInput();
                }

            }catch(Exception $e){
                Session::flash('error', 'Error adding Security Payments');
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
     * @param  \App\Models\SecurityPayments  $securityPayments
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $securityPayments       = SecurityPayments::find(decrypt($id));

            return view($this->path.'.view',compact('securityPayments'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SecurityPayments  $securityPayments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can($this->authR))
        {
            $bank_accounts          = Bankaccounts::get(['name','id','title']);
            $projects               = Project::get(['name','id']);
            // $category               = categories::where('module_id',17)->get(['name','id']);
            $categories = DB::table('erp_categories as a')->where('a.module_name','security_bid_bond')->get();
            $securityPayments       = SecurityPayments::find(decrypt($id));
            $customer               = Customer::get(['id','name','zip_code']);


            return view($this->path.'.edit',compact('bank_accounts','projects','categories','securityPayments','customer'));
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SecurityPayments  $securityPayments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r,$id)
    {
        if(Auth::user()->can($this->authR))
        {
            $id  = decrypt($id);
            try {
                $security_payments                          = SecurityPayments::find($id);
                $security_payments->project_id              = $r->project_id;
                $security_payments->payment_type            = $r->payment_type;
                $security_payments->payment_method          = $r->payment_method;
                $security_payments->title                   = $r->title;

              //  $security_payments->bank_id                 = $r->bank_id;
             ///   $security_payments->cheque_title            = $r->cheque_title;
             //   $security_payments->cheque_number           = $r->cheque_number;
                $security_payments->date                    = $r->date;
              //  $security_payments->amount                  = $r->amount;
                $security_payments->payment_details         = $r->payment_details;
                $security_payments->customer                = $r->customer;
                $security_payments->comments                = $r->comments;
                $security_payments->customer_id             = $r->customer_id;


                $images                                     = json_decode($security_payments->document_file);

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

                if($security_payments->document_file !=null){
                    foreach($images as $img)
                    {
                        if (!in_array($img,$remove_images)) {
                            array_push($new_images,$img);
                        }
                    }
                }
                $security_payments->document_file = $new_images;

                //Save Files
                if($security_payments->update())
                {
                    // saving items
                    Session::flash('created', 'Security Payments Updated Successfully');
                    return redirect()->route('security_payment_management.index');
                }
                else{
                    Session::flash('error', 'Error updating Security Payments');
                    return redirect()->back()->withInput();
                }
            }catch(Exception $e){
                Session::flash('error', 'Error updating Security Payments');
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
     * @param  \App\Models\SecurityPayments  $securityPayments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if(Auth::user()->can($this->authR))
        {
            try {
                $id = $request->id;
                $security_payments = SecurityPayments::find($id);
                if($security_payments)
                {
                    if($security_payments->document_file !=null){
                        foreach(json_decode($security_payments->document_file) as $img)
                        {
                            FileUploader::RemoveFile($img,$this->folderN);
                        }
                    }
                    $security_payments->delete();
                    return response()->json(['success' => true, 'message' => 'Security Payments deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Security Payments deletion failed'], 422);
                }
            }
            catch(Exception $e){
                Session::flash('error', 'Security Payments not Deleted');
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

                SecurityPayments::find($orderList)->each(function ($security_payments) {
                    if($security_payments)
                    {
                        if($security_payments->document_file !=null){
                            foreach(json_decode($security_payments->document_file) as $img)
                            {
                                FileUploader::RemoveFile($img,$this->folderN);
                            }
                        }
                        $security_payments->delete();
                    }
                    else{
                        return response()->json(['error' => true, 'message' => 'Security Payments deletion failed'], 422);
                    }
                });
                return response()->json(['success' => true, 'message' => 'Security Payments deleted Successfully'], 200);

            }catch(Exception $e){
                Session::flash('error', 'Security Payments not Deleted');
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }
}
