<?php

namespace App\Http\Controllers\User\stakeholders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Investors;
use App\Models\InvestorLedger;
use Auth;
use Session;
use Exception;

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        if(Auth::user()->can('manage-investors'))
        {
            try{
               
                $investors = Investors::orderBy('id','DESC')->get();
                return view('user.stakeholders.investors.index',compact('investors'));
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
        if(Auth::user()->can('manage-investors'))
        {
          return view('user.stakeholders.investors.create');
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
        if(Auth::user()->can('manage-investors'))
        {
            
            $input['name'] = $request->name;
            $input['description'] = $request->description;
            $input['type_of_invester'] = $request->type_of_invester;
            $input['contact_no'] = $request->contact_no;
            $input['status'] = $request->status;
            $input['date_of_creation'] = $request->date_of_creation;
    

            try {

                $investors = Investors::firstOrCreate($input);
               
                if($investors->wasRecentlyCreated)
                {
                    Session::flash('created', 'Investor Added Successfully');
                    $investors = Investors::orderBy('id','DESC')->get();
                    return view('user.stakeholders.investors.index',compact('investors'));
                }   
                else{
                    Session::flash('warning', 'Investors Already Exist');
                    return redirect()->back();
                }

            }
            catch(Exception $e){
            
                Session::flash('error', 'investors not Created');
                return redirect()->route('investors.create');
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
        if(Auth::user()->can('manage-investors'))
        {
            $id = decrypt($id);
            $investor = Investors::find($id);

            $investor_amount = InvestorLedger::where('investor_id',$id)->latest()->first();

            return view('user.stakeholders.investors.view',compact('investor','investor_amount'));
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
        if(Auth::user()->can('manage-investors'))
        {
            $id = decrypt($id);
            $investor = Investors::find($id);
            return view('user.stakeholders.investors.edit',compact('investor'));
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
        if(Auth::user()->can('manage-investors'))
        {

            $input['name'] = $request->name;
            $input['description'] = $request->description;
            $input['type_of_invester'] = $request->type_of_invester;
            $input['contact_no'] = $request->contact_no;
            $input['status'] = $request->status;

           try {    
                $id = decrypt($id);
                $investor = Investors::find($id);
                $investor->update($input);
                $investors = Investors::orderBy('id','DESC')->get();
                Session::flash('updated', 'Investor Updated successfully');
              //  return view('user.stakeholders.investors.index',compact('investors'));
              return redirect()->route('investors.index');

           }
           catch(Exception $e){
            Session::flash('error', 'Investors not updated');
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
        if(Auth::user()->can('manage-investors'))
        {
           try {    
                $investor = Investors::find($id);
            
                if($investor)
                {
                    $investor->delete();
                    return response()->json(['success' => true, 'message' => 'Investor deleted Successfully'], 200);
                }
                else{
                   
                    return response()->json(['error' => true, 'message' => 'Investor deletion failed'], 422);
                }
               
           }
           catch(Exception $e){
            Session::flash('error', 'Investor not Deleted');
            return redirect()->back();
           }
        }
        else{
            return redirect()->route('not_authorized');
        }
    }

    public function changeStatus(Request $request){

        if(Auth::user()->can('manage-investors'))
        {
            $id = $request->id;
          
            $investor = Investors::find($id);
            if($investor)
            {
              $investor->status ? $investor->status = 0 : $investor->status = 1;
              $investor->save();

                return response()->json(['success' => true, 'message' => 'Investor status Updated Successfully','value'=>$investor->status,'class'=>$investor->id], 200);
            }
            else {
                return response()->json(['error' => true, 'message' => 'Investor status updation failed'], 422);
            }
           
        }
        else{
            return redirect()->route('not_authorized');
        }

    }
}
