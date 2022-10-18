<?php
namespace App\Traits;

use App\Models\InvestorLedger;
use Auth;



trait InvestorLedgerTrait {

    public static function add_investor_ledger($title,$investor_id,$investment_type,$amount_ingoing_outgoing,$project_id){
        
        $investor_amount = InvestorLedger::where('investor_id',$investor_id)->latest()->first();
        
        $invsetor_ledger = new InvestorLedger();
        $invsetor_ledger->title = $title;
        $invsetor_ledger->investor_id = $investor_id;
        $invsetor_ledger->investment_type = $investment_type;
        $invsetor_ledger->amount_ingoing_outgoing =  $amount_ingoing_outgoing;
        $invsetor_ledger->project_id = $project_id;
        if($investment_type == 'payment_in')
        {
            if($investor_amount)
                $invsetor_ledger->investor_balance = $investor_amount->investor_balance + $amount_ingoing_outgoing;
            else {
                $invsetor_ledger->investor_balance = $amount_ingoing_outgoing;
            }
        }
        else if($investment_type == 'payment_out')
        {
        
            if($investor_amount)
                $invsetor_ledger->investor_balance = $investor_amount->investor_balance - $amount_ingoing_outgoing;
            else {
                $invsetor_ledger->investor_balance = $amount_ingoing_outgoing;
            }
        }
        $invsetor_ledger->user_id = Auth::user()->id;
        $invsetor_ledger->save();

        return "success";

    }
   
}