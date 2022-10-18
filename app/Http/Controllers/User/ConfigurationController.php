<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuration;
Use Auth;
use Exception;
use Illuminate\Support\Facades\Session;



class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('manage-configurations'))
        {
            try{
                $configurations = Configuration::all();
                return view('user.configurations.index',compact('configurations'));
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
        if(Auth::user()->can('manage-configurations'))
        {
           
            return view('user.configurations.create');

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
        

        if(Auth::user()->can('manage-configurations'))
        {
            try{
                $input['name'] = $request->name; 
                $input['value'] = $request->value;
                $input['label'] = $request->label;
                $configuration = Configuration::firstOrCreate($input);
              
                if($configuration->wasRecentlyCreated)
                {
                    Session::flash('created', 'Configuration Created');
                    return redirect()->route('configurations.index');
                }
                else{
                    Session::flash('warning', 'Configuration Already Exist');
                    return redirect()->route('configurations.create');
                }
              }
              catch(Exception $e){
                  dd($e);
                    Session::flash('Error', 'Configuration not Created');
                    return redirect()->route('configurations.create');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        if(Auth::user()->can('manage-configurations'))
        {
            $configuration = Configuration::find($id);
            return view('user.configurations.edit',compact('configuration'));
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
        if(Auth::user()->can('manage-configurations'))
        {
            $id = decrypt($id);
            $input['name'] = $request->name;
            $input['value'] = $request->value;
            $input['label'] = $request->label;
            $configuration = Configuration::find($id);
            $configuration->update($input);
            $configurations = Configuration::all();
           
            Session::flash('updated', 'Configuration Updated');
            return view('user.configurations.index',compact('configurations'));
        
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
    public function destroy($id)
    {
        //
    }
}
