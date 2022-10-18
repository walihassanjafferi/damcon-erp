<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Configuration;
use Auth;
use Session;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        if(Auth::user()->can('manage-permissions'))
        {
            try{
                $permissions = Permission::orderBy('id','DESC')->get();
                return view('user.permissions.index',compact('permissions'));
            }
            catch(Exception $e)
            {
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
        
        if(Auth::user()->can('manage-permissions'))
        {
            try{
                $modules = Configuration::where('name','project_modules')->get();
                return view('user.permissions.create',compact('modules'));
            }
            catch(Exception $e)
            {
                return redirect()->back();
            }     
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
       /// dd($request->all());
        //
         if(Auth::user()->can('manage-permissions'))
        {
           
            try {
    
                $input['name'] = $request->name;
                $input['slug'] = $request->slug;
                $input['module_id'] = $request->module_id;

                $permission = Permission::firstOrCreate($input);
                if($permission->wasRecentlyCreated)
                {
                    $enc_key = encrypt($permission->id);
                    return response()->json(['data' => $permission,'enc_key'=>$enc_key,'success' => true, 'message' => 'Permission Created Successfully'], 200);
                }
                else {
                    return response()->json(['error' => true, 'message' => 'Permission not Created'], 422);
                }   
    
            }
            catch(Exception $e){
    
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
        if(Auth::user()->can('manage-permissions'))
        { 
            $id = decrypt($id);
            $permission = Permission::find($id);
            return view('user.permissions.edit',compact('permission'));
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
        if(Auth::user()->can('manage-permissions'))
        { 
            $id = decrypt($id);
            $permission = Permission::find($id);
            $input['name'] = $request->name;
            $input['slug'] = $request->slug;
            $permission->update($input);

            if($permission){
               
               $permissions = Permission::all();
               Session::flash('updated', 'permission Updated');
               return view('user.permissions.index',compact('permissions'));
                
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
    public function destroy($id)
    {
        //
    }
}
