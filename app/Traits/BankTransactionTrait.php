<?php
namespace App\Traits;

use App\Models\Bankaccounts;
use App\Models\Import_purchases;
use App\Models\BankTransactions;
use Auth;
use Carbon\Carbon;



trait BankTransactionTrait {


    public static function addTransaction($sender_id,$receiver_id,$amount,$receiving_amount,$paymenttitle,$comments,$title,$date){
        $sender_bank = Bankaccounts::find($sender_id);
        $receiver_bank = Bankaccounts::find($receiver_id);

        $sender_bank_amount =  $sender_bank->avaliable_funds;
        if($amount <= $sender_bank_amount)
        {
            $sender_bank->current_balance =  $sender_bank->current_balance - $amount;
            $sender_bank->avaliable_funds = $sender_bank->avaliable_funds - $amount;
            $sender_bank->save();


            ##sender bank log###
            $bank_transaction = new BankTransactions();
            $bank_transaction->bank_id = $sender_id;
            $bank_transaction->user_id = Auth::user()->id;
            $bank_transaction->transfer_amount = $amount;
            $bank_transaction->transaction_type = 'debited';
            $bank_transaction->remaining_balance = $sender_bank->avaliable_funds;
            $bank_transaction->payment_title = $paymenttitle;
            $bank_transaction->withdraw_amount = $amount;
            $bank_transaction->deposit_amount = 0;
            $bank_transaction->comments = $comments;
            $bank_transaction->title = $title;
            $bank_transaction->transaction_date = $date;
            $bank_transaction->save();
            ##sender bank log###

            $receiver_bank->current_balance = $receiver_bank->current_balance + $receiving_amount;
            $receiver_bank->avaliable_funds = $receiver_bank->avaliable_funds + $receiving_amount;
            $receiver_bank->save();


              ##receiver bank log###
              $bank_transaction = new BankTransactions();
              $bank_transaction->bank_id = $receiver_id;
              $bank_transaction->user_id = Auth::user()->id;
              $bank_transaction->transfer_amount = $receiving_amount;
              $bank_transaction->transaction_type = 'credited';
              $bank_transaction->remaining_balance = $receiver_bank->avaliable_funds;
              $bank_transaction->payment_title = $paymenttitle;
              $bank_transaction->withdraw_amount = 0;
              $bank_transaction->deposit_amount = $amount;
              $bank_transaction->comments = $comments;
              $bank_transaction->title = $title;
              $bank_transaction->transaction_date = $date;
              $bank_transaction->save();
              ##receiver bank log###

            return "success";
        }
        else{
            return "Sender Bank has not sufficient funds";
        }
       
    }

    public static function reverseTransaction($pervious_sender_id, $previous_receiver_id, $previous_sending_amount,$previous_receiving_amount, $new_sender_id, $new_receiver_id,$new_sending_amount,$new_receiving_amount){
       
        $pervious_sender_bank = Bankaccounts::find($pervious_sender_id);
        $previous_receiver_bank = Bankaccounts::find($previous_receiver_id);
         
        $new_sender_bank = Bankaccounts::find($new_sender_id);
        dd($new_receiver_id);
        $new_receiver_bank = Bankaccounts::find($new_receiver_id);
      
        if($new_sending_amount <= $new_sender_bank->avaliable_funds)
        {
               // reverting the transaction
              
               if($previous_receiving_amount <= $new_receiver_bank->avaliable_funds)
                {
                    $pervious_sender_bank->current_balance = $pervious_sender_bank->current_balance + $previous_sending_amount;
                    $pervious_sender_bank->avaliable_funds = $pervious_sender_bank->avaliable_funds + $previous_sending_amount;
                    $pervious_sender_bank->save();

                    $previous_receiver_bank->current_balance = $previous_receiver_bank->current_balance - $previous_receiving_amount;
                    $previous_receiver_bank->avaliable_funds = $previous_receiver_bank->avaliable_funds - $previous_receiving_amount;

                    $previous_receiver_bank->save();

                    $new_sender_bank = Bankaccounts::find($new_sender_id);
                    $new_receiver_bank = Bankaccounts::find($new_receiver_id);

                  //  dd($new_receiver_bank);

                    $new_sender_bank->current_balance = $new_sender_bank->current_balance - $new_sending_amount;
                    $new_sender_bank->avaliable_funds = $new_sender_bank->avaliable_funds - $new_sending_amount;
                    $new_sender_bank->save();
                    
                    $new_receiver_bank->current_balance = $new_receiver_bank->current_balance + $new_receiving_amount;
                    $new_receiver_bank->avaliable_funds = $new_receiver_bank->avaliable_funds + $new_receiving_amount;
                    $new_receiver_bank->save();
     
                    return "success";
                }
                else{
                    return "Banks has not sufficent funds to revert the transactions";
                }
        }
        else{
            return "Sender has not sufficent funds";
        }
            
    }

    ##transaction logs function##

    public static function logTransaction($bank_id,$user_id,$transfer_amount,$transaction_type,$balance,$payment_title,$withdraw_amount,$deposit_amount,$comments,$title,$date){
        if($transfer_amount > 0)
        {
            $bank_transaction = new BankTransactions();
            $bank_transaction->bank_id = $bank_id;
            $bank_transaction->user_id = $user_id;
            $bank_transaction->transfer_amount = $transfer_amount;
            $bank_transaction->transaction_type = $transaction_type;
            $bank_transaction->remaining_balance = $balance;
            $bank_transaction->payment_title = $payment_title;
            $bank_transaction->withdraw_amount = $withdraw_amount;
            $bank_transaction->deposit_amount = $deposit_amount;
            $bank_transaction->comments = $comments;
            $bank_transaction->title = $title;
            $bank_transaction->transaction_date = $date ?? Carbon::now();


            ##calulating overdraft
            $bank = Bankaccounts::find($bank_id);
            $current_balance = $bank->current_balance;
            $overdraft_limit = $bank->overdraft_limit;

            $avaliable_balance = $bank->avaliable_balance;

            if( $current_balance <= 0 )
            {
                // $overdraft_used = $bank->overdraft_used + $transfer_amount;

                $bank->overdraft_used = $current_balance;

                $bank->save();
            }

        
            if($bank_transaction->save())
            {
                return "success";
            }
            else{
                return "Error Occured!";
            }

        }
        else{
            return  "Error Occured!";
        }
    }
}