<?php

namespace bishopm\base\Middleware;

use Closure, Illuminate\Support\Facades\Auth;

class AdminMiddleware {

	public function handle($request, Closure $next)
    {
    	$user=Auth::user();
    	if ($user){
    		return $next($request);
	    } 
    	return redirect('/login');
    }

}