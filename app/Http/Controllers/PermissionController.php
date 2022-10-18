<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //

    public function permissions()
    {   
    	$user = User::find(2);

        return $user->givePermissionsTo('create-tasks');
     
        // dd($user->hasRole('developer')); //will return true, if user has role
        // dd($user->givePermissionsTo('create-tasks'));// will return permission, if not null
        // dd($user->can('create-tasks')); 
    }


}
