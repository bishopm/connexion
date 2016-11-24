<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Models\Household;
use App\Http\Controllers\Controller;

class HouseholdsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
		$data['households']=Household::all();
   		return view('base::households.index',$data);
	}

	public function edit($household)
	{
		$data['household']=Household::find($household);
   		return view('base::households.edit',$data);
	}

	public function show($household)
	{
		$data['household']=Household::find($household);
   		return view('base::households.show',$data);
	}	

	public function create()
	{
   		return "Create a new household";
	}		

}
