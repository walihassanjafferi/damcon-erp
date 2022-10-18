<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
Use Auth;
use Exception;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        if(Auth::user()->can('manage-roles'))
        {
            try{
                $roles = Role::all();
                return view('user.roles.index',compact('roles'));
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
    public function create(Request $request)
    {
        if(Auth::user()->can('manage-roles'))
        {
            return view('user.roles.create');
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
        if(Auth::user()->can('manage-roles'))
        {
          try{
            $input['name'] = $request->name; 
            $input['slug'] = $request->slug;
            $roles = Role::firstOrCreate($input);
          
            if($roles->wasRecentlyCreated)
            {
                Session::flash('created', 'Role Created');
                return redirect()->route('roles.index');
            }
            else{
                Session::flash('warning', 'Role Already Exist');
                return redirect()->route('roles.create');
            }
          }
          catch(Exception $e){
                Session::flash('Error', 'Role not Created');
                return redirect()->route('roles.create');
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
        if(Auth::user()->can('manage-roles'))
        {
            $role = Role::find($id);
            return view('user.roles.edit',compact('role'));
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
      
        $id = decrypt($id);
        if(Auth::user()->can('manage-roles'))
        {
            $input['name'] = $request->name;
            $input['slug'] = $request->slug;
            $role = Role::find($id);
            $role->update($input);
            $roles = Role::all();
           
            Session::flash('updated', 'Role Updated');
            return view('user.roles.index',compact('roles'));
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
