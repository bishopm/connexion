<?php

namespace Bishopm\Connexion\Libraries;

use App;
use Auth, Schema, DB, Illuminate\Support\Facades\Request, Illuminate\Support\Facades\Redirect;

class Helpers {

	public static function is_online()
	{
    	return (checkdnsrr('google.com', 'ANY'));
	}

    public static function perm($action)
	{
		if (Auth::check()){
			$perm=Auth::user()->permission;
            if (count($perm)){
			    $proceed=false;
    			if (($perm[0]->$action==1) or ($perm[0]->admin==1)){
                    $proceed=true;
                }
            } else {
                return false;
            }
			return $proceed;
		} else {
			return Redirect::to('/auth/login');
		}
	}
}
