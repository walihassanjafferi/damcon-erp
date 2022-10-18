<?php

namespace App\Http\Controllers\User\invoiceandincome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bankaccounts;
use App\Models\Investors;
use App\Models\PrincipalInvestment;
use App\Models\Project;
use App\Models\InvestorLedger;
use App\Traits\FileAttachmentsTrait as FileUploader;
use App\Traits\BankTransactionTrait;
use App\Traits\InvestorLedgerTrait;
use DataTables;
use Auth;
use Session;
use Exception;
use Carbon\Carbon;


class PrincipalInvestmentsController extends Controller
{
    
    private $path = 'user.invoicingincomemanagement.principalinvestmentmanagement';
    private $authR   = 'principle_investment_management';

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
            $banks = Bankaccounts::all();
            $investors = Investors::where('status',1)->get();
            $projects               = Project::get(['name','id']);

        
            return view($this->path.'.create',compact('banks','investors','projects'));
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
                
                $amount = (float)str_replace(',', '', $request->cheque_amount);


                  ##checking bank balance
                  if($request->payment == 'out')
                  {
                      $bank = Bankaccounts::find($r->cash_deposit_bank_id);
                      if($amount >= $bank->avaliable_funds)
                      {
                          Session::flash('error','Selected Bank '.$bank->name.' ('.$bank->title.') '.'has not sufficient Balance!');
                          return redirect()->back()->withInput();
                      }
                  }

                $principal_investment = new PrincipalInvestment();
                $principal_investment->title = $request->title;
                $principal_investment->investor_id = $request->investor_id;
                $principal_investment->project_id = $request->project_id;

                $principal_investment->current_balance_investor = $request->current_balance_investor;
                $principal_investment->cash_deposit_bank_id = $request->cash_deposit_bank_id;
                $principal_investment->cheque_number = $request->cheque_number;
                $principal_investment->cheque_clearing_date = $request->cheque_clearing_date;
                $principal_investment->cheque_amount = $amount;
                $principal_investment->payment_details = $request->payment_details;
                $principal_investment->comments = $request->comments;
                $principal_investment->payment = $request->payment;


                ##saving images

                $new_images = [];

                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,'PrincipalInvestment','principal_investment');
                        array_push($new_images,$filename);
                    }
                }

             
                
                $principal_investment->document_file = json_encode($new_images);

                if($principal_investment->save())
                {
                    $principal_investment->refresh();
                    ##depositing cheque in bank

                    if($principal_investment->payment == 'in')
                    {
                        $bank = Bankaccounts::find($principal_investment->cash_deposit_bank_id);
                        $bank->current_balance = $bank->current_balance + $principal_investment->cheque_amount;
                        $bank->avaliable_funds =  $bank->avaliable_funds + $principal_investment->cheque_amount;
                        if($bank->save())
                        {   
                            $bank->refresh();
                            $user_id = Auth()->user()->id;
                            $transaction_log = BankTransactionTrait::logTransaction(
                                $bank->id,
                                $user_id,
                                $principal_investment->cheque_amount,
                                'credited',
                                $bank->avaliable_funds,
                                $request->title,
                                0,
                                $principal_investment->cheque_amount,
                                $principal_investment->comments,
                                $principal_investment->title,
                                Carbon::now()
                            );
                        }
                    }
                    else if($principal_investment->payment == 'out'){
                       
                        $bank = Bankaccounts::find($principal_investment->cash_deposit_bank_id);
                        $bank->current_balance = $bank->current_balance - $principal_investment->cheque_amount;
                        $bank->avaliable_funds =  $bank->avaliable_funds - $principal_investment->cheque_amount;
                        if($bank->save())
                        {   
                            $bank->refresh();
                            $user_id = Auth()->user()->id;
                            $transaction_log = BankTransactionTrait::logTransaction(
                                $bank->id,
                                $user_id,
                                $principal_investment->cheque_amount,
                                'debited',
                                $bank->avaliable_funds,
                                $request->title,
                                0,
                                $principal_investment->cheque_amount,
                                $principal_investment->comments,
                                $principal_investment->title,
                                Carbon::now()
                            );
                        }
                    }
                    
                    ##depositing cheque in bank

                    ##Investor ledger payment

                    InvestorLedgerTrait::add_investor_ledger(
                        $principal_investment->title,
                        $principal_investment->investor_id,
                        $principal_investment->payment == 'in' ? 'payment_in' : 'payment_out',
                        $principal_investment->cheque_amount,
                        $principal_investment->project_id
                    );

                    ##Investor ledger payment


                    Session::flash('success','Principal Investment Created successfully!');
                    return redirect()->route('principalinvestment.index');
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
                $principal_investment = PrincipalInvestment::find($id);
                return view($this->path.'.view',compact('principal_investment'));

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
            $investors = Investors::where('status',1)->get();
            $principal_investment = PrincipalInvestment::find($id);
            $projects               = Project::get(['name','id']);
            return view($this->path.'.edit',compact('banks','investors','principal_investment','projects'));

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
                $principal_investment = PrincipalInvestment::find($id);
                $principal_investment->title = $request->title;
               // $principal_investment->investor_id = $request->investor_id;
                //$principal_investment->current_balance_investor = $request->current_balance_investor;
                //$principal_investment->cash_deposit_bank_id = $request->cash_deposit_bank_id;
               // $principal_investment->cheque_number = $request->cheque_number;
               // $principal_investment->cheque_clearing_date = $request->cheque_clearing_date;
               // $principal_investment->cheque_amount = $request->cheque_amount;
               
                $principal_investment->payment_details = $request->payment_details;
                $principal_investment->comments = $request->comments;

                ##updating images
            
                $images = json_decode($principal_investment->document_file);

                $remove_images = [];
                $new_images    = [];
    
    
                if(isset($request->remove_images)){
                    $remove_images = explode(',',$request->remove_images);
                    foreach($remove_images as $img)
                    {
                        FileUploader::RemoveFile($img,'MiscIncome');
                    }
                }
      
                if($request->hasfile('document_file'))
                {
                    foreach($request->file('document_file') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,'PrincipalInvestment','principal_investment');
                        array_push($new_images,$filename);
                    }
                }
    
                if($principal_investment->document_file !=null){
                    foreach($images as $img)
                    {
                        if (!in_array($img,$remove_images)) {
                            array_push($new_images,$img);
                        }
                    }
                }
    
                
                $principal_investment->document_file = $new_images;
                
                ##updating images

                if($principal_investment->save())
                { 
                    Session::flash('success','Principal Investment Updated successfully!');
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


    public function getAjaxPrincipleInvestment(Request $request){
        if (Auth::user()->can($this->authR))
        {
            if ($request->ajax()) {

                $data = PrincipalInvestment::orderby('id','desc')->get();

                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                
                    $actionBtn = '<a href="'.route('principalinvestment.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                    <a href="'.route('principalinvestment.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>&nbsp; &nbsp;';
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
                ->addColumn('investor_id',function($row){
                    $checkBtn = ucfirst($row->investor->name) ?? ' ';
                    return $checkBtn;
                })

                ->addColumn('check_clearing_date',function($row){
                    $checkBtn = date('d-M-Y',strtotime($row->cheque_clearing_date));
                    return $checkBtn;
                    
                })

                ->addColumn('cheque_amount',function($row){
                    $checkBtn = $row->cheque_amount;
                    return number_format($checkBtn,2);
                })


            
                ->rawColumns(['action','checkbox','title','investor_id','cheque_clearing_date','cheque_amount'])
                ->make(true);

            }
        } 
        else{
            return redirect()->route('not_authorized');
        }
    }

    public function getInvestorBalance(Request $request){
        
        $id = $request->id;
        $invsetor_ledger = InvestorLedger::where('investor_id',$id)->latest()->first();
       
        if($invsetor_ledger)
        {
            return response()->json(['success' => true, 'message' => $invsetor_ledger->investor_balance], 200);
        }
        else{
            return response()->json(['success' => true, 'message' =>0], 200);

        }
    }
}
