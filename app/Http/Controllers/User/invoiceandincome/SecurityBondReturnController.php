<?php

namespace App\Http\Controllers\User\invoiceandincome;
use App\Models\SecurityPayments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bankaccounts;
use App\Models\Security_bidbondreturns;
use App\Traits\BankTransactionTrait;
use App\Traits\FileAttachmentsTrait as FileUploader;
use DataTables;
use Auth;
use Session;
use Exception;
use DB;

class SecurityBondReturnController extends Controller
{

    private $path = 'user.invoicingincomemanagement.securitybidbondreturns';
    private $authR   = 'security-bid-bond-returns';
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

            $security_payments = SecurityPayments::all();
            $banks = Bankaccounts::all();

            return view($this->path.'.create',compact('security_payments','banks'));
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
            try{
                /*Checking bank amount */
                DB::beginTransaction(); 

                $bank = Bankaccounts::find($request->cash_deposit_bank_id);
                // if($request->amount > $bank->avaliable_funds)
                // {
                //     Session::flash('error','Selected Bank '.$bank->name.' ('.$bank->title.') '.'has not sufficient Balance!');
                //     return redirect()->back()->withInput();
                // }
                    
                /********************/
                $security_bond_return = new Security_bidbondreturns();
                $security_bond_return->title = $request->title;
                $security_bond_return->pre_security_bid_id = $request->security_payment_id;
                $security_bond_return->customer_id = $request->customer_id;
                $security_bond_return->customer_name = $request->customer_name;
                $security_bond_return->cheque_clearing_date = $request->cheque_clearing_date;
                $security_bond_return->cheque_number = $request->cheque_number;
                $security_bond_return->amount = $request->amount;
                $security_bond_return->cash_deposit_bank_id = $request->cash_deposit_bank_id;         
                $security_bond_return->customer_name = $request->customer_name;
                $security_bond_return->payment_details = $request->payment_details;
                $security_bond_return->comments = $request->comments;

                // saving images
    
                $new_images = [];
                    
                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,'SecurityBond','security_bond_return');
                        array_push($new_images,$filename);
                    }
                }
              
                $security_bond_return->document_file = json_encode($new_images);

                if($security_bond_return->save())
                {

                    ##depositing cheque in bank
                
                    $bank->current_balance = $bank->current_balance + $security_bond_return->amount;
                    $bank->avaliable_funds =  $bank->avaliable_funds + $security_bond_return->amount;
                    if($bank->save())
                    {   
                        
                        $bank->refresh();
                        $user_id = Auth()->user()->id;
                        $transaction_log = BankTransactionTrait::logTransaction(
                            $bank->id,
                            $user_id,
                            $security_bond_return->cheque_amount,
                            'credited',
                            $bank->avaliable_funds,
                            'Security Bond Payment',
                            $security_bond_return->cheque_amount,
                            0,
                            $request->comments,
                            $request->title,
                            $security_bond_return->cheque_clearing_date
                        );
                    }
                    ##depositing cheque in bank

                    DB::commit();

                    Session::flash('success','Security/Bid Bond Returns Created successfully!');
                    return redirect()->route('securitybondreturns.index');
                }
                else{
                    Session::flash('success','Error Occured!');
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
        if(Auth::user()->can($this->authR))
        {
            try{
                $id = decrypt($id);
                $security_bid_returns = Security_bidbondreturns::find($id);
                return view($this->path.'.view',compact('security_bid_returns'));
            }
            catch(Exception $e){
                Session::flash('error',$e->getMessage());
                return redirect()->back();
            }
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
        if(Auth::user()->can($this->authR))
        {   
            $id = decrypt($id);
            $banks = Bankaccounts::all();
            $security_bond_return = Security_bidbondreturns::find($id); 
            $security_payments = SecurityPayments::all();

           
            return view($this->path.'.edit',compact('banks','security_bond_return','security_payments'));
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
                $security_bond_return = Security_bidbondreturns::find($id);
                $security_bond_return->title = $request->title;
              //  $security_bond_return->pre_security_bid_id  = $request->security_payment_id;
                $security_bond_return->customer_id = $request->customer_id;
                $security_bond_return->customer_name = $request->customer_name;
                $security_bond_return->cheque_clearing_date = $request->cheque_clearing_date;
                $security_bond_return->cheque_number = $request->cheque_number;
               // $security_bond_return->amount = $request->amount;
              //  $security_bond_return->cash_deposit_bank_id = $request->cash_deposit_bank_id;         
                $security_bond_return->customer_name = $request->customer_name;
                $security_bond_return->payment_details = $request->payment_details;
                $security_bond_return->comments = $request->comments;

                ##updating images
        
                $images = json_decode($security_bond_return->document_file);

                $remove_images = [];
                $new_images    = [];
    
    
                if(isset($request->remove_images)){
                    $remove_images = explode(',',$request->remove_images);
                    foreach($remove_images as $img)
                    {
                        FileUploader::RemoveFile($img,'SecurityBond');
                    }
                }
               
                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,'SecurityBond','security_bond_return');
                        array_push($new_images,$filename);
                    }
                }
    
                if($security_bond_return->document_file !=null){
                    foreach($images as $img)
                    {
                        if (!in_array($img,$remove_images)) {
                            array_push($new_images,$img);
                        }
                    }
                }
      
                 
                $security_bond_return->document_file = $new_images;
                 
                ##updating images

                if($security_bond_return->save())
                {
                    Session::flash('success','Security/Bid Bond Returns Updated successfully!');
                    return redirect()->back();
                }
                else{
                    Session::flash('success','Error Occured!');
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

    public function getAjaxSecurityBondReturns(Request $request){
        if (Auth::user()->can($this->authR))
        {
            if ($request->ajax()) {

                $data = Security_bidbondreturns::orderby('id','desc')->get();

                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                
                    $actionBtn = '<a href="'.route('securitybondreturns.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                    <a href="'.route('securitybondreturns.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;';
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

                ->addColumn('customer_name',function($row){
                    $checkBtn = $row->customer->name ?? 'Not found!';
                    return $checkBtn;
                })

                ->addColumn('pre_security_bid_id',function($row){
                    $checkBtn = $row->customer->name.' ('.($row->payment_security->paymenttype->name ?? '').')';
                    return $checkBtn;
                })


                ->addColumn('bank',function($row){
                    $checkBtn = $row->bank->name;
                    return $checkBtn;
                })

                ->addColumn('cheque_clearing_date',function($row){
                  
                    $checkBtn = date('d-M-Y',strtotime($row->cheque_clearing_date));
                   
                    return $checkBtn;
                    
                })

                ->addColumn('amount',function($row){
                    $checkBtn = number_format($row->amount);
                    return  $checkBtn;
                })

                ->rawColumns(['action','checkbox','title','customer_name','pre_security_bid_id','bank','cheque_clearing_date','amount'])
                ->make(true);

            }
        } 
        else{
            return redirect()->route('not_authorized');
        }
    }
}
