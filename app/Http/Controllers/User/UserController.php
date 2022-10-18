<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use APP\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use Session;
use Exception;

use App\Traits\FileAttachmentsTrait as FileUploader;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(Auth::user()->can('manage-users'))
        {
            try{
                $users = User::orderBy('id','DESC')->get();
                return view('user.users.index',compact('users'));
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
        if(Auth::user()->can('manage-users'))
        {
            $roles = Role::all();
            $permissions = Permission::orderBy('module_id','asc')->get();
            return view('user.users.create',compact('roles','permissions'));
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
      
        if(Auth::user()->can('manage-users'))
        {
            
            try{

                $input['name'] = $request->name;
                $input['email'] = $request->email;
                $input['password'] = Hash::make($request->password);
                $input['status'] = $request->status;
                $input['role_id'] = $request->role_id;

              
                
                $permissions_array = $request->permissions;
               
                //return $permissions_array;
                $user = User::firstOrCreate($input);

              //  dd($user);
                
                if($user->wasRecentlyCreated)
                {
                   
                    $user->permissions()->sync($permissions_array);
                  
                    Session::flash('success','User Created successfully');   
                    return redirect()->route('user.users.index');
                }
                else{
                 
                    Session::flash('error','Error Creating User');   
                    return redirect()->back();
                }
      
               
            }
            catch(Exception $e)
            {
                Session::flash('error','Duplicate Entry Exception');   
                return redirect()->back();
             
            }
            

        }
        else{
          
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
        $roles = Role::orderBy('name','asc')->get();
        $permissions = Permission::orderBy('module_id','asc')->get();

        if(Auth::user()->can('manage-users'))
        {
            $user = User::find($id);
            $user_permissions = $user->permissions()->pluck('id')->toArray();
            return view('user.users.edit',compact('user','roles','user_permissions','permissions'));
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
        if(Auth::user()->can('manage-users'))
        {
           try{
               
            
            $user = User::find($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->status = $request->status;
            $user->role_id = $request->role_id;
            $user->update();

            $permissions_array = $request->permissions;
            $user->permissions()->sync($permissions_array);
            $permissions_array = $request->permissions;

            Session::flash('success','User Upated successfully');   
            return redirect()->route('users.index');


           }
           catch(Exception $e){
            Session::flash('error','User Updation failed');   
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
    public function destroy($id, Request $request)
    {
        //
        $id = $request->id;
        if(Auth::user()->can('manage-users'))
        {
           try {    
                $user = User::find($id);
            
                if($user)
                {
                    $user->delete();
                    return response()->json(['success' => true, 'message' => 'User deleted Successfully'], 200);
                }
                else{
                   
                    return response()->json(['error' => true, 'message' => 'User deletion failed'], 422);
                }
               
           }
           catch(Exception $e){
            Session::flash('error', 'User not Deleted');
            return redirect()->back();
           }
        }
        else{
            return redirect()->route('not_authorized');
        }
       


    }
    public function changeStatus(Request $request){

        if(Auth::user()->can('manage-users'))
        {
            $id = $request->id;
          
            $user = User::find($id);
            if($user)
            {
              $user->status ? $user->status = 0 : $user->status = 1;
              $user->save();

                return response()->json(['success' => true, 'message' => 'Users status Updated Successfully'], 200);
            }
            else {
                return response()->json(['error' => true, 'message' => 'Users status updation failed'], 422);
            }
           
        }
        else{
            return redirect()->route('not_authorized');
        }

    }

    public function profile($id){
        
        $id = decrypt($id);
        $user = User::find($id);
        return view('user.users.profile',compact('user'));
    }

    public function profileUpdate(Request $request,$id){
        
       // dd($request->all());
        if($request->has('name'))
        {
            $id = decrypt($id);
            $user = User::find($id);
            $user->name = $request->name;
            
            if($request->hasfile('document_file'))
            {
                $image = $request->file('document_file');

                $fileName = FileUploader::uploadFile($image,"user_profile_images","user_Profile");
                $user->document_file = json_encode($fileName);

            }
            
            $user->save();

            Session::flash('success',"Profile Updated Successfully!");
            return redirect()->back();
        }
        else if($request->has(['old_pass','new_password','confirm_password']))
        {
          
            $this->validate($request, [
                'old_pass' => 'required',
                'new_password' => 'required|min:8',
                'confirm_password' => 'required_with:new_password|same:new_password|min:8'
            ]);

            $id = decrypt($id);

            $user = User::find($id);
            
        
            if (!Hash::check($request->old_pass, Auth::user()->password)) 
            {
                Session::flash('error','Old Password is not same!');
                return redirect()->back()->withInput();
            }

            $user->password = bcrypt($request->new_password);

            $user->save();

            Session::flash('success','Password Updated Successfully!');
            return redirect()->back();

        }

     



        


    }
}
