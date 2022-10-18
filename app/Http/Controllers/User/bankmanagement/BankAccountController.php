<?php

namespace App\Http\Controllers\User\bankmanagement;
use App\Models\Bankaccounts;
use App\Models\inter_bank_transfer;
use App\Http\Controllers\Controller;
use App\Models\BankTransactions;
use Illuminate\Http\Request;
use Auth;
use Session;
use Exception;
use DB;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('manage-banks'))
        {
            try{
                $bankaccounts = Bankaccounts::orderBy('id','DESC')->get();
                
                return view('user.banksmanagement.bankaccounts.index',compact('bankaccounts'));
            }
            catch(Exception $e){
                return redirect()->back();
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
        //
        if(Auth::user()->can('manage-banks'))
        {
          
          return view('user.banksmanagement.bankaccounts.create');
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
    
        if(Auth::user()->can('manage-banks'))
        {
          try{
            
            DB::beginTransaction();

            $input["name"] = $request->name;
            $input['title'] = $request->title;
            $input['account_number'] = $request->account_number;
            
            $input['current_balance'] = (float)str_replace(',', '', $request->current_balance);
            $input['overdraft_facility'] = $request->overdraft_facility;
            $input['overdraft_limit'] = (float)str_replace(',', '',$request->overdraft_limit);
            $input['avaliable_funds'] = $request->avaliable_funds;
            $input['opening_date'] = $request->opening_date;
            $input['overdraft_used'] = $request->overdraft_used;
          
            // $titles = Bankaccounts::pluck('title')->toArray();

            // if (in_array($request->title, $titles))
            // {
            //     Session::flash('warning', 'Bank Account title Already Exist');
            //     return redirect()->back()->withInput();
            // }

            $bankaccount = Bankaccounts::firstOrCreate($input);
          
            if($bankaccount->wasRecentlyCreated)
            {
                DB::commit();

                Session::flash('created', 'Bank Account Added Successfully');
                //$suppliers = Suppliers::orderBy('id','DESC')->get();
                return redirect()->route('bankaccounts.index');
            }
            else{
                Session::flash('warning', 'Bank Account Already Exist');
                return redirect()->back()->withInput();
            }
          }
          catch(Exception $e){

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        if(Auth::user()->can('manage-banks'))
        { 
            $id = decrypt($id);
            $bankaccount = Bankaccounts::find($id);
            // $transfers = inter_bank_transfer::where('sender_bank_id',$id)->orwhere('receiver_bank_id',$id)->orderBy('id','DESC')->get();
            $transaction_logs = BankTransactions::where('bank_id',$id)->join('bankaccounts','bank_transactions.bank_id','=','bankaccounts.id')->select('bank_transactions.*','bankaccounts.name as bank_name')->orderBy('bank_transactions.id','Desc')->get();
            // dd($transaction_logs);
            return view('user.banksmanagement.bankaccounts.view',compact('bankaccount','transaction_logs'));

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
        if(Auth::user()->can('manage-banks'))
        {
            $id = decrypt($id);
            $bankaccount = Bankaccounts::find($id);
           
            return view('user.banksmanagement.bankaccounts.edit',compact('bankaccount'));
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
        //
        if(Auth::user()->can('manage-interbank-transfer'))
        {
            $input["name"] = $request->name;
            $input['title'] = $request->title;
            $input['account_number'] = $request->account_number;
            $input['current_balance'] = $request->current_balance;
            $input['overdraft_facility'] = $request->overdraft_facility;
            $input['overdraft_limit'] = $request->overdraft_limit;
            $input['avaliable_funds'] = $request->avaliable_funds;
            $input['opening_date'] = $request->opening_date;


           try {    
                $id = decrypt($id);
                $bankaccount = Bankaccounts::find($id);
                $bankaccount->update($input);
                Session::flash('updated', 'Bank Account Updated Successfully');
                return redirect()->route('bankaccounts.index');


           }
           catch(Exception $e){
            Session::flash('error', 'Bankaccount not updated');
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
    public function destroy($id,Request $request)
    {
        $id = $request->id;
        if(Auth::user()->can('manage-banks'))
        {
           try {    
                $bankaccount = Bankaccounts::find($id);
            
                if($bankaccount)
                {
                    $bankaccount->delete();
                    return response()->json(['success' => true, 'message' => 'Bankaccount deleted Successfully'], 200);
                }
                else{
                   
                    return response()->json(['error' => true, 'message' => 'Bankaccount deletion failed'], 422);
                }
               
           }
           catch(Exception $e){
            Session::flash('error', 'Bankaccount not Deleted');
            return redirect()->back();
           }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }
}
