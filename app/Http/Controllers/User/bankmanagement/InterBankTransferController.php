<?php

namespace App\Http\Controllers\User\bankmanagement;
use App\Models\Bankaccounts;
use App\Models\inter_bank_transfer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\BankTransactionTrait;
use Auth;
use Session;
use Exception;
use DB;

class InterBankTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('manage-interbank-transfer'))
        {
            try{
                $transfers = inter_bank_transfer::orderBy('id','DESC')->get();
                
                return view('user.banksmanagement.interbanktransfers.index',compact('transfers'));
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
        if(Auth::user()->can('manage-interbank-transfer'))
        {
        
          DB::beginTransaction();

           
         $banks = Bankaccounts::all();
         
          //$banks = Bankaccounts::pluck('name','id')->toArray();  
          return view('user.banksmanagement.interbanktransfers.create',compact('banks'));
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
        //
        if(Auth::user()->can('manage-interbank-transfer'))
        {

          try{
            
            DB::beginTransaction();

            $amount = (int)str_replace(',', '',$request->amount);

            $input["title_of_transfer"] = $request->title_of_transfer;
            $input['sender_bank_id'] = $request->sender_bank_id;
            $input['receiver_bank_id'] = $request->receiver_bank_id;
            $input['transaction_date'] = $request->transaction_date;
            $input['transaction_type'] = $request->transaction_type;
            $input['cheque_no'] = $request->cheque_no;
            $input['amount'] = $amount;
            $input['comments'] = $request->comments;

             
            $amount = $amount;
            $sender_bank = Bankaccounts::find($request->sender_bank_id);
            $receiver_bank = Bankaccounts::find($request->receiver_bank_id);
            $user_id = Auth::user()->id;

            $sender_bank_amount =  $sender_bank->avaliable_funds;

            if($amount<=$sender_bank_amount)
            {
                $sender_bank->current_balance =  $sender_bank->current_balance - $amount;
                $sender_bank->avaliable_funds = $sender_bank_amount - $amount;
                $sender_bank->save();
                ##sender Bank log
                $transaction_log = BankTransactionTrait::logTransaction(
                    $sender_bank->id,
                    $user_id,
                    $amount,
                    'debited'
                    ,$sender_bank->avaliable_funds,
                    'Interbank Transfer',
                    $amount, //withdraw amount
                    0, //deposit amount
                    $request->comments,
                    $request->title_of_transfer,
                    $request->transaction_date
                );

                $input['sender_bank_current_balance'] = $sender_bank->current_balance;
                $receiver_bank->avaliable_funds =  $receiver_bank->avaliable_funds + $amount;
                $receiver_bank->current_balance =  $receiver_bank->current_balance + $amount;
                $receiver_bank->save();
                ##Receiver Bank log
                $transaction_log = BankTransactionTrait::logTransaction(
                    $receiver_bank->id,
                    $user_id,
                    $amount,
                    'credited',
                    $receiver_bank->avaliable_funds,
                    'Interbank Transfer',
                    0,
                    $amount,
                    $request->comments,
                    $request->title,
                    $request->transaction_date
                );


                $input['receiver_bank_current_balance'] = $receiver_bank->current_balance;

            }
            else{
                Session::flash('error', 'Sender Bank has not sufficient amount');
                return redirect()->back()->withInput();
            }
            

          
            $interbank_transfer = inter_bank_transfer::firstOrCreate($input);
          
            if($interbank_transfer->wasRecentlyCreated)
            {
                DB::commit();

                Session::flash('created', 'Inter-Bank transfer Added Successfully');
                //$suppliers = Suppliers::orderBy('id','DESC')->get();
                return redirect()->route('interbanktransfer.index');
            }
            else{
                Session::flash('warning', 'Inter-bank Already Exist');
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
        if(Auth::user()->can('manage-interbank-transfer'))
        {   
            $id = decrypt($id);
            $inter_transfer = inter_bank_transfer::find($id);
            return view('user.banksmanagement.interbanktransfers.view',compact('inter_transfer'));
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
        //
        if(Auth::user()->can('manage-interbank-transfer'))
        {
            $id = decrypt($id);
            $transfer = inter_bank_transfer::find($id);
            $banks = Bankaccounts::pluck('name','id')->toArray();  

            return view('user.banksmanagement.interbanktransfers.edit',compact('transfer','banks'));
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
            $input["title_of_transfer"] = $request->title_of_transfer;
            $input['sender_bank_id'] = $request->sender_bank_id;
            $input['receiver_bank_id'] = $request->receiver_bank_id;
            $input['transaction_date'] = $request->transaction_date;
            $input['transaction_type'] = $request->transaction_type;
            $input['cheque_no'] = $request->cheque_no;
            $input['amount'] = $request->amount;
            $input['comments'] = $request->comments;
            $newamount =  $request->amount;

           
           try {    
                $id = decrypt($id);
                $transfer = inter_bank_transfer::find($id);
                $sender_bank = Bankaccounts::find($transfer->sender_bank_id);
                $sender_bank_amount =  $sender_bank->current_balance;
               
                $receiver_bank = Bankaccounts::find($transfer->receiver_bank_id);
                $previous_transfer = $transfer->amount;
                $sender_bank_new = Bankaccounts::find($request->sender_bank_id);

              
                if($newamount <= $sender_bank_new->avaliable_funds)
                {

                    // reverting the transaction
                    $sender_bank->avaliable_funds = $sender_bank->avaliable_funds + $previous_transfer;
                    $sender_bank->current_balance = $sender_bank->current_balance + $previous_transfer;
                    $sender_bank->save();
                    $receiver_bank->avaliable_funds = $receiver_bank->avaliable_funds - $previous_transfer;
                    $receiver_bank->current_balance = $receiver_bank->current_balance - $previous_transfer;
                    $receiver_bank->save();
                    
                    $sender_bank_new = Bankaccounts::find($request->sender_bank_id);
                    $receiver_bank_new = Bankaccounts::find($request->receiver_bank_id);
    
                 
                   
                    $sender_bank_new->avaliable_funds = $sender_bank_new->avaliable_funds - $newamount;
                    $sender_bank_new->current_balance = $sender_bank_new->current_balance - $newamount;
                    $sender_bank_new->save();

              

                    $receiver_bank_new->avaliable_funds = $receiver_bank_new->avaliable_funds + $newamount;
                    $receiver_bank_new->current_balance = $receiver_bank_new->current_balance + $newamount;
                    $receiver_bank_new->save();

                    //return "check new banks";
                    $transfer->update($input);

                    Session::flash('updated', 'Inter-Bank transfer Updated Successfully');
                    return redirect()->route('interbanktransfer.index');
                }
                else{
                    Session::flash('error', 'Sender Bank has not sufficient amount');
                    return redirect()->back()->withInput();
                }
                

                
                // if($sender_bank->id == $transfer->sender_bank_id && $receiver_bank->id == $transfer->receiver_bank_id) 
                // {
                //     if($newamount > $previous_transfer)
                //     {
                //      //   return "Hello";
                //         $diff = $newamount - $previous_transfer;
                //         if($diff <= $sender_bank->current_balance)
                //         {
                //             $sender_bank->current_balance = $sender_bank->current_balance - $diff;
                //             $sender_bank->save();
                //             $receiver_bank->current_balance = $receiver_bank->current_balance + $diff;
                //             $receiver_bank->save();
                //         }
                //         else {
                //             Session::flash('error', 'Sender bank has not sufficient amount');
                //             return redirect()->back()->withInput();
                //         } 
    
                //     }
                //     else if($newamount < $previous_transfer){
                       
                //         $diff = $previous_transfer - $newamount;
                        
                //         if($diff <= $receiver_bank->current_balance )
                //         {
                //             $sender_bank->current_balance =$sender_bank->current_balance + $diff;
                //             $sender_bank->save();
                //             $receiver_bank->current_balance = $receiver_bank->current_balance - $diff;
                //             $receiver_bank->save();
                //         }
                //         else {
                //             Session::flash('error', 'Receiver bank has not sufficient amount');
                //             return redirect()->back()->withInput();
                //         }    
                //     }

                // }
                // else{
                   
                //     if($previous_transfer <= $receiver_bank->current_balance )
                //     {
                //         $sender_bank->current_balance = $sender_bank->current_balance + $previous_transfer;
                //         $sender_bank->save();
                //         $receiver_bank->current_balance = $receiver_bank->current_balance - $previous_transfer;
                //         $receiver_bank->save();


                //         if($newamount <=  $sender_bank->current_balance)
                //         {
                //             $sender_bank->current_balance = $sender_bank_amount - $newamount;
                //             $sender_bank->save();
                //             $receiver_bank->current_balance = $receiver_bank->current_balance + $newamount;
                //             $receiver_bank->save();
                //         }
                //         else{
                //             Session::flash('error', 'Sender Bank has not sufficient amount');
                //             return redirect()->back()->withInput();
                //         }
                //     }
                //     else {
                //         Session::flash('error', 'Receiver bank has not sufficient amount');
                //         return redirect()->back()->withInput();
                //     }    
                   
                // }


                
             
               


           }
           catch(Exception $e){
               dd($e);
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
        //
        $id = $request->id;
        if(Auth::user()->can('manage-interbank-transfer'))
        {
           try {    
                $transfer = inter_bank_transfer::find($id);
            
                if($transfer)
                {
                    $transfer->delete();
                    return response()->json(['success' => true, 'message' => 'Inter-Bank Transfer deleted Successfully'], 200);
                }
                else{
                   
                    return response()->json(['error' => true, 'message' => 'Inter-Bank Transfer deletion failed'], 422);
                }
               
           }
           catch(Exception $e){
            Session::flash('error', 'Inter-Bank Transfer not Deleted');
            return redirect()->back();
           }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }
}
