<?php
namespace App\Traits;

use App\Models\Supplier_tax_ledger;
use App\Models\Supplier_payables;
use App\Models\Suppliers;
use Carbon\Carbon;

use Auth;



trait SupplierTaxledgerTrait {

    public static function add_supplier_tax ($supplier_id,$module_id,$transaction_type,$module_name,$payment_title,$amount){
        
        $supplier_tax_ledger = new Supplier_tax_ledger();
        $supplier_tax_ledger->supplier_id = $supplier_id;
        $supplier_tax_ledger->transaction_type = $transaction_type;
        $supplier_tax_ledger->module_name = $module_name;
        $supplier_tax_ledger->module_id = $module_id;
        $supplier_tax_ledger->payment_title = $payment_title;
        $supplier_tax_ledger->amount = $amount; 
        $supplier_tax_ledger->save();
        return "success";

    }

    public static function edit_supplier_tax ($supplier_id,$module_id,$transaction_type,$module_name,$payment_title,$amount)
    {
      
        $supplier_tax_ledger = Supplier_tax_ledger::where('module_name',$module_name)->where('module_id',$module_id)->first();
        $supplier_tax_ledger = Supplier_tax_ledger::find($supplier_tax_ledger->id);
       // dd( $supplier_tax_ledger );
        $supplier_tax_ledger->supplier_id = $supplier_id;
        $supplier_tax_ledger->transaction_type = $transaction_type;
        $supplier_tax_ledger->module_name = $module_name;
        $supplier_tax_ledger->module_id = $module_id;
        $supplier_tax_ledger->payment_title = $payment_title;
        //dd($amount);
        $supplier_tax_ledger->amount = $amount; 
        $supplier_tax_ledger->update();


        return "success";
    }



    // adding purchase supplier_payable
    public static function add_supplier_purchase_pay($title,$supplier_id, $purchase_amount, $payment_amount){
        
        $supplier_balance = Suppliers::find($supplier_id);
        
        $balance = ($supplier_balance->balance + $purchase_amount);
        
        $supplier_balance->balance = $balance;
        $supplier_balance->save();

      
        $supplier_payable = new Supplier_payables();
        $supplier_payable->title = $title;
        $supplier_payable->transaction_date = Carbon::now()->format('d-m-y');
        $supplier_payable->supplier_id = $supplier_id;
        $supplier_payable->purchase_amount = $purchase_amount;
        $supplier_payable->payment_amount = $payment_amount;
        $supplier_payable->balance = $supplier_balance->balance;
        $supplier_payable->save();
       


    }

    // adding payment supplier_payable

    public static function add_supplier_payment_pay($title,$supplier_id, $purchase_amount, $payment_amount){
        
        $supplier_balance = Suppliers::find($supplier_id);
        
        $balance = ($supplier_balance->balance - $payment_amount);
        
        $supplier_balance->balance = $balance;
        $supplier_balance->save();

      
        $supplier_payable = new Supplier_payables();
        $supplier_payable->title = $title;
        $supplier_payable->transaction_date = Carbon::now()->format('d-m-y');
        $supplier_payable->supplier_id = $supplier_id;
        $supplier_payable->purchase_amount = $purchase_amount;
        $supplier_payable->payment_amount = $payment_amount;
        $supplier_payable->balance = $supplier_balance->balance;
        $supplier_payable->save();
       


    }

   
}