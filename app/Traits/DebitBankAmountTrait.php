<?php
namespace App\Traits;

use App\Models\Bankaccounts;
use App\Models\BankTransactions;

trait DebitBankAmountTrait {

    public static function debitAmount($bank_id,$amount,$user_id){

            $bank = Bankaccounts::where('id',$bank_id)->first();
          //  dd($bank->avaliable_funds);
            if($amount <= $bank->avaliable_funds)
            {
                $bank->current_balance = $bank->current_balance - $amount;
                $bank->avaliable_funds = $bank->avaliable_funds - $amount;
                $bank->save();

                $bank->refresh();
                $transaction = new BankTransactions();
                $transaction->bank_id = $bank->id;
                $transaction->user_id = $user_id;
                $transaction->transfer_amount = $amount;
                $transaction->transaction_type = "debited";
                $transaction->remaining_balance = $bank->avaliable_funds;
                $transaction->save();

                return "success";
            }
            else
            {
                return "failed";
            }
        

    }
}