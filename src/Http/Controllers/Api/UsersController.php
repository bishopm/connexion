<?php

namespace Bishopm\Connexion\Http\Controllers\Api;

use Illuminate\Http\Request;
use Bishopm\Connexion\Models\User;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function byphone(Request $request)
    {
        return User::where('phone', $request->phone)->first();
    }

}
