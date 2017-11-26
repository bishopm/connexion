<?php

namespace Bishopm\Connexion\Http\Controllers\Auth;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Bishopm\Connexion\Models\User;

class ApiAuthController extends Controller
{

    use SendsPasswordResetEmails;
    
    public function login(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('name', 'password');
        $user=User::with('roles')->where('name',$request->input('name'))->first();
        $fullname=$user->individual->firstname . " " . $user->individual->surname;
        $indiv_id=$user->individual_id;
        $user_id=$user->id;
        $permissions=$user->roles[0]->permissions;
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
        return response()->json(compact('token','fullname','indiv_id','user_id','permissions'));
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['name' => 'required']);
        $user=User::where('name','=',$request->name)->first();
        if ($user){
            $arr['email']=$user->email;

            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = $this->broker()->sendResetLink($arr);

            return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($response)
                    : $this->sendResetLinkFailedResponse($request, $response);
        } else {
            return "Sorry! This is not a valid username";
        }
    }

}