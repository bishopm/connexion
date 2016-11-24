<?php

namespace bishopm\base\Http\Controllers;

use App\User, App\Http\Controllers\Controller;

class UsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
	}

	public function edit()
	{
	}

	public function show($user)
	{
		if ($user=="current"){
			$data['user']=User::find(1);
		} else {
			$data['user']=User::find($user);
		}
		return view('base::users.show',$data);
	}	

	public function create()
	{
   		return "Create a new user";
	}		

}
