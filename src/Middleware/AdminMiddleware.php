<?php

namespace bishopm\base\Middleware;

use Closure, Illuminate\Support\Facades\Auth;

class AdminMiddleware {

	public function handle($request, Closure $next)
    {
    	dd($request);
    	$user=Auth::user();
    	if ($user){
    		return $next($request)->with('user', $user);
	    } 
    	return redirect('/login');
    }

}