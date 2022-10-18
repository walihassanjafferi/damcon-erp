<?php
namespace App\Traits;

use App\Models\TaxBodyLedger;
use Auth;



trait TaxBodyledgerTrait {

    public static function add_taxbody_ledger ($tax_body_id,$module_id,$transaction_type,$module_name,$payment_title,$amount){
        
        $tax_body_ledger = new TaxBodyLedger();
        $tax_body_ledger->tax_body_id = $tax_body_id;
        $tax_body_ledger->transaction_type = $transaction_type;
        $tax_body_ledger->module_name = $module_name;
        $tax_body_ledger->module_id = $module_id;
        $tax_body_ledger->payment_title = $payment_title;
        $tax_body_ledger->amount = $amount; 
        $tax_body_ledger->save();
        return "success";

    }

    public static function edit_taxbody_ledger ($tax_body_id,$module_id,$transaction_type,$module_name,$payment_title,$amount)
    {
      
        $tax_body_ledger = TaxBodyLedger::where('module_name',$module_name)->where('module_id',$module_id)->first();
        $tax_body_ledger = TaxBodyLedger::find( $tax_body_ledger->tax_body_id);
        $tax_body_ledger->tax_body_id = $tax_body_id;
        $tax_body_ledger->transaction_type = $transaction_type;
        $tax_body_ledger->module_name = $module_name;
        $tax_body_ledger->module_id = $module_id;
        $tax_body_ledger->payment_title = $payment_title;
        $tax_body_ledger->amount = $amount; 
        $tax_body_ledger->update();
        return "success";
    }

   
}