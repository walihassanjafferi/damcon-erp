<?php

namespace App\Http\Middleware;

use App\Models\Permission;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        
        if(!$request->user()->role) {

            abort(404);

       }

       if($permission !== null && !$request->user()->can($permission)) {

             abort(404);
       }

       return $next($request);
    }
}
