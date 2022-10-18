<?php

namespace App\Http\Controllers\User\stakeholders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Project;
use App\Models\CustomerPosManagement;


use Auth;
use Session;
use Exception;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
   
        if(Auth::user()->can('manage-customers'))
        {
          
            try{
                $customers = Customer::orderBy('id','DESC')->get();
                return view('user.stakeholders.customers.index',compact('customers'));
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
        if(Auth::user()->can('manage-customers'))
        {
          return view('user.stakeholders.customers.create');
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
        if(Auth::user()->can('manage-customers'))
        {
            $input['name'] = $request->name;
            $input['address'] = $request->address;
            $input['street'] = $request->street;
            $input['state'] = $request->state;
            $input['city'] = $request->city;
            $input['country'] = $request->Country;
            $input['zip_code'] = $request->zipcode;
            $input['cp1_name'] = $request->cp1_name;
            $input['cp1_phone_no'] = $request->cp1_phone;
            $input['cp1_cell_no'] = $request->cp1_cell;
            $input['cp1_email'] = $request->cp1_email;
            $input['cp1_fax'] = $request->cp1_fax;
            $input['cp2_name'] = $request->cp2_name;
            $input['cp2_phone_no'] = $request->cp2_phone;
            $input['cp2_cell_no'] = $request->cp2_cell;
            $input['cp2_email'] = $request->cp2_email;
            $input['cp2_fax'] = $request->cp2_fax;
            $input['ntn_number'] = $request->ntn_no;
            $input['strn_number'] = $request->strn_no;
            $input['status'] = $request->status;


            try {

                $customer = Customer::firstOrCreate($input);
               
                if($customer->wasRecentlyCreated)
                {
                    Session::flash('created', 'Customer Added Successfully');
                    $customers = Customer::orderBy('id','DESC')->get();
                    return view('user.stakeholders.customers.index',compact('customers'));
                }   
                else{
                    Session::flash('warning', 'Customer Already Exist');
                    return redirect()->route('customer.create');
                }

            }
            catch(Exception $e){

                Session::flash('error', 'Customer not Created');
                return redirect()->route('customers.create');
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
        if(Auth::user()->can('manage-customers'))
        {
            $id = decrypt($id);
            $customer = Customer::findorfail($id);
            $project_ids = Project::where('customer_id',$id)->orderBy('id','desc')->pluck('id');
            $purchase_order = CustomerPosManagement::whereIn('project_id',$project_ids)->get();
        
            return view('user.stakeholders.customers.view',compact('customer','purchase_order'));
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
        if(Auth::user()->can('manage-customers'))
        {
            $id = decrypt($id);
            $customer = Customer::find($id);
            return view('user.stakeholders.customers.edit',compact('customer'));
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
        if(Auth::user()->can('manage-customers'))
        {

            $input['name'] = $request->name;
            $input['address'] = $request->address;
            $input['street'] = $request->street;
            $input['state'] = $request->state;
            $input['city'] = $request->city;
            $input['country'] = $request->country;
            $input['zip_code'] = $request->zip_code;
            $input['cp1_name'] = $request->cp1_name;
            $input['cp1_phone_no'] = $request->cp1_phone_no;
            $input['cp1_cell_no'] = $request->cp1_phone_no;
            $input['cp1_email'] = $request->cp1_email;
            $input['cp1_fax'] = $request->cp1_fax;
            $input['cp2_name'] = $request->cp2_name;
            $input['cp2_phone_no'] = $request->cp2_phone_no;
            $input['cp2_cell_no'] = $request->cp2_cell_no;
            $input['cp2_email'] = $request->cp2_email;
            $input['cp2_fax'] = $request->cp2_fax;
            $input['ntn_number'] = $request->ntn_number;
            $input['strn_number'] = $request->strn_number;
            $input['status'] = $request->status;

           try {    
                $id = decrypt($id);
                $customer = Customer::find($id);
                $customer->update($input);
                $customers = Customer::orderBy('id','DESC')->get();
                Session::flash('updated', 'Customer Updated successfully');
               // return view('user.stakeholders.customers.index',compact('customers'));
               return redirect()->route('customers.index');

           }
           catch(Exception $e){
            Session::flash('error', 'Customers not updated');
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
    public function destroy(Request $request,$id)
    {
        $id = $request->id;
        if(Auth::user()->can('manage-customers'))
        {
           try {    
                $customer = Customer::find($id);
            
                if($customer)
                {
                    $customer->delete();
                    return response()->json(['success' => true, 'message' => 'Customer deleted Successfully'], 200);
                }
                else{
                   
                    return response()->json(['error' => true, 'message' => 'Customer deletion failed'], 422);
                }
               
           }
           catch(Exception $e){
            Session::flash('error', 'Customers not Deleted');
            return redirect()->back();
           }
        }
        else{
            return redirect()->route('not_authorized');
        }
       

    }


    public function changeStatus(Request $request){

        if(Auth::user()->can('manage-customers'))
        {
            $id = $request->id;
          
            $customer = Customer::find($id);
            if($customer)
            {
              $customer->status ? $customer->status = 0 : $customer->status = 1;
              $customer->save();

                return response()->json(['success' => true, 'message' => 'Customer status Updated Successfully','value'=>$customer->status,'class'=>$customer->id], 200);
            }
            else {
                return response()->json(['error' => true, 'message' => 'Customer status updation failed'], 422);
            }
           
        }
        else{
            return redirect()->route('not_authorized');
        }

    }
}
