<?php

namespace Bishopm\Connexion\Http\Controllers\Auth;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Bishopm\Connexion\Models\User;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('name', 'password');
        $user=User::where('name',$request->input('name'))->first();
        $fullname=$user->individual->firstname . " " . $user->individual->surname;
        $indiv_id=$user->individual_id;
        //Log::info('API login attempt: ' . json_encode($credentials));

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token','fullname','indiv_id'));
    }
}
