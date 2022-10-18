<?php

namespace App\Http\Controllers\User\stakeholders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suppliers_type;
use App\Models\Suppliers;
use App\Models\SupplierPosManagement;
use App\Models\SupplierPayments;
use App\Models\Supplier_tax_ledger;
use App\Models\Supplier_payables;
use Auth;
use Session;
use Exception;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      
        if(Auth::user()->can('manage-suppliers'))
        {
            try{
                $suppliers = Suppliers::orderBy('id','DESC')->get();
                return view('user.stakeholders.suppliers.index',compact('suppliers'));
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

        if(Auth::user()->can('manage-suppliers'))
        {
            $supplier_type = Suppliers_type::all();
            return view('user.stakeholders.suppliers.create',compact('supplier_type'));
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
      
        if(Auth::user()->can('manage-suppliers'))
        {
          try{
            
            $input["name"] = $request->name;
            $input['suppliers_types_id'] = $request->suppliers_types_id;
            $input['address'] = $request->address;
            $input['street'] = $request->street;
            $input['state'] = $request->state;
            $input['city'] = $request->city;
            $input['country'] = $request->country;
            $input['zip_code'] = $request->zip_code;
            $input['cp1_name'] = $request->cp1_name;
            $input['cp1_phone_no'] = $request->cp1_phone_no;
            $input['cp1_cell_no'] = $request->cp1_cell_no;
            $input['cp1_email'] = $request->cp1_email;
            $input['cp1_fax'] = $request->cp1_fax;
            $input['ntn_number'] = $request->ntn_number;
            $input['strn_number'] = $request->strn_number;
            $input['bank_name'] = $request->bank_name;
            $input['bank_account_title'] = $request->bank_account_title;
            $input['bank_account_number'] = $request->bank_account_number;
            $input['status'] = $request->status;
            $input['date_of_creation'] = $request->date_of_creation;


            



            $suppliers = Suppliers::firstOrCreate($input);
          
            if($suppliers->wasRecentlyCreated)
            {
                Session::flash('created', 'Suppliers Added Successfully');
                $suppliers = Suppliers::orderBy('id','DESC')->get();
                return redirect()->route('suppliers.index',compact('suppliers'));
            }
            else{
                Session::flash('warning', 'Suppliers Already Exist');
                return redirect()->route('suppliers.create');
            }
          }
          catch(Exception $e){
                Session::flash('error', $e->getMessage());
                return redirect()->route('suppliers.create')->withInput();
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
        if(Auth::user()->can('manage-suppliers'))
        {
            $id = decrypt($id);
            $supplier = Suppliers::find($id);
            $supplier_pos = SupplierPosManagement::where('supplier_id',$id)->orderBy('id','desc')->get();
            $supplier_tax_ledgers = Supplier_tax_ledger::where('supplier_id',$id)->orderBy('created_at','desc')->get();
            $supplier_payment = SupplierPayments::where('supplier_id',$id)->orderBy('created_at','desc')->get();
            $supplier_payables_ledger = Supplier_payables::where('supplier_id',$id)->orderBy('created_at','desc')->get();

            // if($supplier->suppliers_types_id  == 1)
            // {

            // }
            // elseif($supplier->suppliers_types_id  == 2)
            // {

            // }
            // elseif($supplier->suppliers_types_id  == 3)
            // {
                
            // }
            // elseif($supplier->suppliers_types_id  == 4)
            // {
                
            // }
            // elseif($supplier->suppliers_types_id  == 5)
            // {
                
            // }
            return view('user.stakeholders.suppliers.view',compact('supplier','supplier_pos','supplier_tax_ledgers','supplier_payment','supplier_payables_ledger'));
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
        if(Auth::user()->can('manage-suppliers'))
        {
            $id = decrypt($id);
            $supplier = Suppliers::find($id);
            $supplier_type = Suppliers_type::pluck('name','id')->toArray();
         //   dd($supplier_type);
            return view('user.stakeholders.suppliers.edit',compact('supplier','supplier_type'));
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
        if(Auth::user()->can('manage-suppliers'))
        {

            $input["name"] = $request->name;
            $input['suppliers_types_id'] = $request->suppliers_types_id;
            $input['address'] = $request->address;
            $input['street'] = $request->street;
            $input['state'] = $request->state;
            $input['city'] = $request->city;
            $input['country'] = $request->country;
            $input['zip_code'] = $request->zip_code;
            $input['cp1_name'] = $request->cp1_name;
            $input['cp1_phone_no'] = $request->cp1_phone_no;
            $input['cp1_cell_no'] = $request->cp1_cell_no;
            $input['cp1_email'] = $request->cp1_email;
            $input['cp1_fax'] = $request->cp1_fax;
            $input['ntn_number'] = $request->ntn_number;
            $input['strn_number'] = $request->strn_number;
            $input['bank_name'] = $request->bank_name;
            $input['bank_account_title'] = $request->bank_account_title;
            $input['bank_account_number'] = $request->bank_account_number;
            $input['status'] = $request->status;

           try {    
                $id = decrypt($id);
                $supplier = Suppliers::find($id);
                $supplier->update($input);
              //  $suppliers = Suppliers::orderBy('id','DESC')->get();
                Session::flash('updated', 'Supplier Updated Successfully');
                //return view('user.suppliers.index',compact('suppliers'));
                return redirect()->route('suppliers.index');


           }
           catch(Exception $e){
               dd($e);
            Session::flash('error', 'Supplier not updated');
            return redirect()->back();
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
        if(Auth::user()->can('manage-suppliers'))
        {
           try {    
                $supplier = Suppliers::find($id);
            
                if($supplier)
                {
                    $supplier->delete();
                    return response()->json(['success' => true, 'message' => 'Supplier deleted Successfully'], 200);
                }
                else{
                   
                    return response()->json(['error' => true, 'message' => 'Supplier deletion failed'], 422);
                }
               
           }
           catch(Exception $e){
            Session::flash('error', 'Supplier not Deleted');
            return redirect()->back();
           }
        }
        else{
            return redirect()->route('not_authorized');
        }
       
    }

    public function changeStatus(Request $request){

        if(Auth::user()->can('manage-suppliers'))
        {
            $id = $request->id;
          
            $supplier = Suppliers::find($id);
            if($supplier)
            {
              $supplier->status ? $supplier->status = 0 : $supplier->status = 1;
              $supplier->save();

                return response()->json(['success' => true, 'message' => 'Supplier status Updated Successfully','value'=>$supplier->status,'class'=>$supplier->id], 200);
            }
            else {
                return response()->json(['error' => true, 'message' => 'Supplier status updation failed'], 422);
            }
           
        }
        else{
            return redirect()->route('not_authorized');
        }

    }
}
