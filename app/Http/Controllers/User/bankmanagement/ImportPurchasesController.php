<?php

namespace App\Http\Controllers\User\bankmanagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Import_purchases;
use App\Models\Taxation_bodies;
use App\Models\Bankaccounts;
use App\Models\import_purchases_items;
use App\Models\inter_bank_transfer;
use App\Traits\BankTransactionTrait;
use App\Traits\FileAttachmentsTrait as FileUploader;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Traits\TaxBodyledgerTrait as TaxBodyLedger;
use Auth;
use Session;
use File;
use DB;


class ImportPurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::user()->can('manage-import-purchases'))
        {
            try{
                $purchases = Import_purchases::orderBy('id','DESC')->get();
                return view('user.banksmanagement.importpurchases.index',compact('purchases'));
            }
            catch(Exception $e){
                Session::flash('error', 'Purchases Not Found!');
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
        if(Auth::user()->can('manage-import-purchases'))
        {
            $tax_bodies = Taxation_bodies::pluck('name','id')->toArray();
            $banks = Bankaccounts::all();
            return view('user.banksmanagement.importpurchases.create',compact('tax_bodies','banks'));
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
        if(Auth::user()->can('manage-import-purchases'))
        {
            DB::beginTransaction();

            $sending_amount_format = (int)str_replace(',', '', $request->sending_amount);
            $receiving_amount_format = (int)str_replace(',', '', $request->cash_receiving_amount);

            $input['title'] = $request->title;
            $input['supplier_name'] = $request->supplier_name;
            $input['supplier_ntn_number'] = $request->supplier_ntn_number;
            $input['supplier_strn_number'] = $request->supplier_strn_number;
            $input['invoice_no'] = $request->invoice_no;
            $input['tax_id'] = $request->tax_id;
            $input['taxation_month'] = $request->taxation_month;
            $input['tax_body_percentage'] = $request->tax_body_percentage;
            $input['date'] = $request->date;
            $input['payment_sending_bank'] = $request->sending_bank;
            $input['sending_amount'] = $sending_amount_format;
            $input['cash_receiving_bank'] = $request->cash_receiving_bank;
            $input['cash_receiving_amount'] = $receiving_amount_format;
            $input['sales_tax_withheld_at_source_per'] = $request->sales_tax_withheld_at_source_per;
            $input['supplier_withheld_tax_1_deduction_per'] = $request->supplier_withheld_tax_1_deduction_per;
            $input['damcon_gain_percentage'] = $request->damcon_gain_percentage;
            $input['comments'] = $request->comments;

            try {

                $checkInvoice =  Import_purchases::where('invoice_no',$request->invoice_no)->get();

                if($checkInvoice->isNotEmpty() )
                {
                    Session::flash('error', 'Duplicate Invoice number');
                    return redirect()->back()->withInput();
                }
                // saving images
                $new_images = [];
                $items_name = array();
                $items_quantity = array();
                $items_cost = array();


                if($request->hasfile('images'))
                {
                
                    foreach($request->file('images') as $image)
                    {
                        $filename = FileUploader::uploadFile($image,'import_purchases','import_purchase');
                        array_push($new_images,$filename);
                    }

                }

                //dd($image_names);

                $input['attachment_of_sales_tax'] = json_encode($new_images);


                // saving images


                // DEALING WITH BANKS
                ##sending bank payments
                $transaction = BankTransactionTrait::addTransaction(
                    $request->sending_bank,
                    $request->cash_receiving_bank,
                    $sending_amount_format,
                    $receiving_amount_format,
                   'ImportPurchase Transaction',
                   $request->comments,
                   $request->title,

                );

                if($transaction !="success")
                {
                    Session::flash('error',$transaction);
                   return redirect()->back()->withInput();
                }

                ##receiving bank payments


                // saving import purchase

                /**calculate formulas**/
                $total_items_cost = []; 

                $import_purchase = Import_purchases::firstOrCreate($input);
                if($import_purchase->wasRecentlyCreated)
                {
                    //saving items
                    $items_name = $request->item_name;
                    $items_quantity = $request->item_quantity;
                    $item_cost = $request->item_cost;

                    foreach($items_name as $index=>$item)
                    {
                        $input_items['item_name'] = $item;
                        $input_items['item_qunatity'] = $items_quantity[$index];
                        $input_items['item_cost'] = $item_cost[$index];
                        $input_items['import_purchases_id'] = $import_purchase->id;
                        $items = import_purchases_items::firstOrCreate($input_items);

                        // saving cost in array
                        $total = floatval($item) * floatval($items_quantity[$index]);
                        array_push($total_items_cost,$total);
                    }
                    // saving items

                

                    // calculating formuals

            
                    $sub_total_amount = array_sum($total_items_cost);

                    $tax_amount =  $sub_total_amount * ($request->tax_body_percentage/100);

                    // calculation formulas

                    // Enter value in tax body ledger
                    TaxBodyLedger::add_taxbody_ledger(
                        $import_purchase->tax_id,
                        $import_purchase->id,
                        "payment_in",
                        'Import Purchases',
                        'Tax Body Amount',
                        $tax_amount
                    );



                    DB::commit();

                    Session::flash('created', 'Import Purchase Added Successfully');

                    return redirect()->route('importpurchases.index');

                }
                else{

                    Session::flash('error', 'Error adding Import Purchase');
                    return redirect()->back()->withInput();
                }
                // saving import purchase
            }
            catch(Exception $e){
                DB::rollback();
                Session::flash('error', 'Error adding Import Purchase');
                return redirect()->back()->withInput();
                Session::flash('error', 'Error adding Import Purchase');
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
        if(Auth::user()->can('manage-import-purchases'))
        {
            $id = decrypt($id);
            $imports = Import_purchases::find($id);
            $banks = Bankaccounts::pluck('name','id')->toArray();
            $tax_bodies = Taxation_bodies::pluck('name','id')->toArray();
            $images = json_decode($imports->attachment_of_sales_tax);

            $items_cost = array();
            $items_quantity  = array();
            $total_items_cost = array();
            // calculatigng items cost
            foreach( $imports->purchase_items as $item)
            {
                array_push($items_cost,$item->item_cost);
                array_push($items_quantity,$item->item_qunatity);

            }

            foreach ($items_cost as $index=>$item)
            {
                $total = $item * $items_quantity[$index];
                array_push($total_items_cost,$total);
            }

            $sub_total_amount = array_sum($total_items_cost);
           
            // calculating tax
            $tax_body_percentage = intval($imports->tax_body_percentage);
            if(is_int($tax_body_percentage)){
                $tax_body_percentage = ($tax_body_percentage/100);

                $tax_amount = $sub_total_amount *  $tax_body_percentage;

            }
            // total amount

            $total_amount = $sub_total_amount + $tax_amount;

            // sales tax withheld
            $sales_tax_withheld_at_source_per = intval($imports->sales_tax_withheld_at_source_per);

            if(is_int($sales_tax_withheld_at_source_per)){
                $sales_tax_withheld_at_source_per = $tax_amount * ($sales_tax_withheld_at_source_per/100);
            }

            // supplier tax withheld
            $supplier_withheld_tax_1_deduction_per = intval($imports->supplier_withheld_tax_1_deduction_per);
            if(is_int($supplier_withheld_tax_1_deduction_per)){
        
                $supplier_withheld_tax_1_deduction_per = $total_amount * ($supplier_withheld_tax_1_deduction_per/100);
            }

            // damcon gain percentage
            $damcon_gain_percentage = intval($imports->damcon_gain_percentage);
            if(is_int($damcon_gain_percentage)){
                $damcon_gain_percentage = $sub_total_amount * ($damcon_gain_percentage/100);
            }

            // supplier gain
            $supplier_gain = $tax_amount - $supplier_withheld_tax_1_deduction_per - $damcon_gain_percentage;

            $sending_amount = $total_amount - $supplier_withheld_tax_1_deduction_per;

            $receiving_amount = $sending_amount - $supplier_gain;

            $transaction_expense =  $sending_amount - $receiving_amount + $supplier_withheld_tax_1_deduction_per;


            return view('user.banksmanagement.importpurchases.view',compact('imports','banks','tax_bodies','images',
            'sub_total_amount','tax_amount','total_amount','sales_tax_withheld_at_source_per',
            'supplier_withheld_tax_1_deduction_per','damcon_gain_percentage','supplier_gain','sending_amount','receiving_amount','transaction_expense','tax_body_percentage'));
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

        if(Auth::user()->can('manage-import-purchases'))
        {
            $id = decrypt($id);
            $imports = Import_purchases::find($id);
            $banks = Bankaccounts::pluck('name','id')->toArray();
            $tax_bodies = Taxation_bodies::pluck('name','id')->toArray();

            $images = json_decode($imports->attachment_of_sales_tax);

            return view('user.banksmanagement.importpurchases.edit',compact('imports','banks','tax_bodies','images'));
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

      //  dd($request->all());
        if(Auth::user()->can('manage-import-purchases'))
        {
           
            $input['title'] = $request->title;
            $input['supplier_name'] = $request->supplier_name;
            $input['supplier_ntn_number'] = $request->supplier_ntn_number;
            $input['supplier_strn_number'] = $request->supplier_strn_number;
            $input['invoice_no'] = $request->invoice_no;
            $input['tax_id'] = $request->tax_id;
            $input['taxation_month'] = $request->taxation_month;
            $input['tax_body_percentage'] = $request->tax_body_percentage;
            $input['date'] = $request->date;
         //   $input['payment_sending_bank'] = $request->sending_bank;
           // $input['sending_amount'] = $request->sending_amount;
          //  $input['cash_receiving_bank'] = $request->cash_receiving_bank;
          //  $input['cash_receiving_amount'] = $request->cash_receiving_amount;
            $input['sales_tax_withheld_at_source_per'] = $request->sales_tax_withheld_at_source_per;
            $input['supplier_withheld_tax_1_deduction_per'] = $request->supplier_withheld_tax_1_deduction_per;
            $input['damcon_gain_percentage'] = $request->damcon_gain_percentage;
            $input['comments'] = $request->comments;

            try{


                $image_names = array();
                $items_name = array();
                $items_quantity = array();
                $items_cost = array();
                $remove_images = array();
                $new_images = array();

                $id = decrypt($id);
                $imports = Import_purchases::find($id);
                $images = json_decode($imports->attachment_of_sales_tax);

                // removing selected images
                if(isset($request->remove_images))
                {
                    $remove_images = explode(',',$request->remove_images);
                    foreach($remove_images as $img)
                    {
                        $path = ('/import_invoices/'.$img);
                        if (Storage::disk('public')->exists($path))
                        {
                            Storage::disk('public')->delete($path);
                        }
                    }

                }

                if($request->hasfile('images'))
                {
                    foreach($request->file('images') as $image)
                    {
                        $image = $image;
                        $fileName = rand(10,5000).time() . '.' . $image->getClientOriginalExtension();

                        $img = Image::make($image->getRealPath());
                        $img->resize(300, 300, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $img->stream();
                        Storage::disk('local')->put('public/import_invoices'.'/'.$fileName, $img, 'public');
                        array_push($image_names,$fileName);
                        $fileName = '';
                    }
                }

                foreach($images as $img)
                {
                    if (!in_array($img,$remove_images)) {
                       array_push($new_images,$img);
                    }
                }

                $new_images = array_merge($new_images,$image_names);
                $input['attachment_of_sales_tax'] =  $new_images;

                // $banks_transfer = BankTransactionTrait::reverseTransaction($imports->payment_sending_bank,$imports->cash_receiving_bank,$imports->sending_amount,$imports->cash_receiving_amount,
                // $request->sending_bank,$request->cash_receiving_bank,$request->sending_amount,$request->cash_receiving_amount);




                if(true)
                {

                    $imports->update($input);

                    $import_purchases_items = import_purchases_items::where('import_purchases_id', $id)->delete();

                    $items_name = $request->item_name;
                    $items_quantity = $request->item_quantity;
                    $item_cost = $request->item_cost;

                    foreach($items_name as $index=>$item)
                    {

                        $input_items['item_name'] = $item;
                        $input_items['item_qunatity'] = $items_quantity[$index];
                        $input_items['item_cost'] = $item_cost[$index];
                        $input_items['import_purchases_id'] = $imports->id;
                        $items = import_purchases_items::create($input_items);
                    }
                    // saving items

                    Session::flash('updated', 'Import Purchase Edited Sucessfully');
                    return redirect()->route('importpurchases.index');


                }
                else{
                    Session::flash('error', $banks_transfer);
                    return redirect()->back()->withInput();
                }

            }
            catch(Exception $e){
                Session::flash('error', 'Error adding Import Purchase');
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
    public function destroy($id, Request $request)
    {
        $id = $request->id;
        if(Auth::user()->can('manage-import-purchases'))
        {
           try {
                $import_purchase = Import_purchases::find($id);

                if($import_purchase)
                {
                   // $import_purchase->delete();
                    return response()->json(['success' => true, 'message' => 'Import Purchase deleted Successfully'], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Import Purchase deletion failed'], 422);
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

    public function getTax(Request $request){
       
        $id = $request->id;

        $type = $request->type;

        if(!$request->filled('type'))
        {
            $type = "sales_tax_percentage_items";
            $withhold = "withholding_items";
        }
        else{
            $type = "sales_tax_percentage_services";
            $withhold = "withholding_services";

        }

        
        $tax_body = Taxation_bodies::find($id);
        if($tax_body)
        {
            return response()->json(['success' => true, 'message' => $tax_body->$type,'withhold'=>$tax_body->$withhold], 200);
        }
        else{
            return response()->json(['error' => true, 'message' =>" Tax Body not found"], 404);

        }

    }
}
