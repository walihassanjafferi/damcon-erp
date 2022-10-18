<?php

namespace App\Http\Controllers\User\damconmanagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bankaccounts;
use App\Models\directorwithdraws;
use App\Traits\BankTransactionTrait;
use DataTables;
use Auth;
use Session;
use Exception;
use DB;
use Carbon\Carbon;


class DirectorWithdrawController extends Controller
{

    private $path    = 'user.damconmanagement.directorwithdraws';
    private $authR   = 'director_withdraws';
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
            $banks = Bankaccounts::get();
            
            return view($this->path.'.create',compact('banks'));
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
            try {
                    DB::beginTransaction();
        
                    $debited_bank_id = $request->debited_bank_id;
        
                    $bank = Bankaccounts::find($debited_bank_id);

                    $amount = (float)str_replace(',', '', $request->amount);
        
                    if($amount > $bank->avaliable_funds)
                    {
                        Session::flash('error','Selected Bank '.$bank->name.' ('.$bank->title.') '.'has not sufficient Balance!');
                        return redirect()->back()->withInput();
                    }
        
                    $directorWithdraw = new directorwithdraws();
        
                    $directorWithdraw->partner_name = Auth::user()->name;
                    $directorWithdraw->user_id = Auth::user()->id;
                    $directorWithdraw->debited_bank_id = $request->debited_bank_id;
                    $directorWithdraw->cheque_number = $request->cheque_number;
                    $directorWithdraw->cheque_clearing_date = $request->cheque_clearing_date;
                    $directorWithdraw->cheque_title = $request->cheque_title;
                    $directorWithdraw->amount = $amount;
                    $directorWithdraw->comments = $request->comments;
                    
                    if($directorWithdraw->save())
                    {
                        ##depositing cheque in bank
                            
                        $bank->current_balance = $bank->current_balance - $directorWithdraw->amount;
                        $bank->avaliable_funds =  $bank->avaliable_funds - $directorWithdraw->amount;
                        if($bank->save())
                        {   
                            
                            $bank->refresh();
                            $user_id = Auth()->user()->id;
                            $transaction_log = BankTransactionTrait::logTransaction(
                                $bank->id,
                                $user_id,
                                $directorWithdraw->amount,
                                'debited',
                                $bank->avaliable_funds,
                                'Director Withdraw',
                                $directorWithdraw->amount,
                                0,
                                $directorWithdraw->comments,
                                '',
                                carbon::now()
                            );
                        }
                        ##depositing cheque in bank
        
                        DB::commit();
        
                        Session::flash('success','DirectorWithdraws created successfully!');
                        return redirect()->route('directorwithdraw.index');
                    }
                    else{
                        Session::flash('success','Error Occured!');
                        return redirect()->back()->withInput();
                    }
        
            
                    return view($this->path.'.create',compact('banks'));
                
            } catch (Exception $e) {
                DB::rollback();
                Session::flash('error',$e->getMessage());
                return redirect()->back();
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
            $director = directorwithdraws::find($id);
            return view($this->path.'.view',compact('director'));
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
            $banks = Bankaccounts::get();
            $withdraw = directorwithdraws::find($id);
            return view($this->path.'.edit',compact('banks','withdraw'));
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
            $id = decrypt($id);
            $withdraw = directorwithdraws::find($id);
            $withdraw->cheque_clearing_date = $request->cheque_clearing_date;
            $withdraw->comments = $request->comments;
            $withdraw->save();

            Session::flash('success','Director Withdraw Updated Successfully!');
            return redirect()->back();


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

    public function getAjaxdirectorwithdraw(Request $request){
       
        if ($request->ajax()) {

            $data = directorwithdraws::all();

            return Datatables::of($data)
            
            ->addIndexColumn()

            ->addColumn('action', function($row){
                // <a  onclick="deleteItem('.$row->id.')"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>
                 $actionBtn = '<a href="'.route('directorwithdraw.show',encrypt($row->id)).'"><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>&nbsp; &nbsp;
                 <a href="'.route('directorwithdraw.edit',encrypt($row->id)).'"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>';
                 return $actionBtn;
             })
             ->addColumn('checkbox',function($row){
                $checkBtn = '<input type="checkbox" class="item_check"  value="'.$row->id.'">';
                return $checkBtn;
            })

            ->addColumn('bank',function($row){
                $checkBtn = $row->bank->name;
                return $checkBtn;
            })

            ->addColumn('amount',function($row){
                $checkBtn = number_format($row->amount,2);
                return $checkBtn;
            })

            ->addColumn('cheque_clearing_date',function($row){
                $checkBtn = date('d-M-Y',strtotime($row->cheque_clearing_date));
                return $checkBtn;
            })

            ->rawColumns(['action','bank','cheque_clearing_date','checkbox','amount'])    
            ->make(true);
        }
    }
}
