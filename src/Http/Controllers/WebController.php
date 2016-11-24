<?php

namespace bishopm\base\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('base::dashboard');
    }
}
