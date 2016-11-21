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

}
