<?php

namespace Bishopm\Connexion\Http\Controllers\Auth;

use Bishopm\Connexion\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, VerifiesUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $redirectAfterVerification = '/';
    protected $redirectIfVerificationFails = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $users=User::where('email','=',$data['email'])->get();
        foreach ($users as $user){
            if (Hash::check($data['password'],$user->password)){
                return "Duplicate";
            }
        }
        return User::create([
            'name' => $data['email'],
            'email' => $data['email'],
            'individual_id' => $data['individual_id'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        $individuals=array();
        return view('connexion::auth.register',compact('individuals'));
    }

    /**
    * Handle a registration request for the application.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        if ($user == "Duplicate"){
            $errmsg="This combination of email and password is taken. Choose another email address or password";
            return view('connexion::auth.register',compact('errmsg'));
        } else {
            event(new Registered($user));
            $this->guard()->login($user);
            UserVerification::generate($user);
            UserVerification::emailView('connexion::emails.newuser');
            UserVerification::send($user, 'Welcome!');
            return $this->registered($request, $user)
                            ?: redirect($this->redirectPath());
        }
    }
}
