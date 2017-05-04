<?php

namespace Bishopm\Connexion\Http\Controllers\Auth;

use Bishopm\Connexion\Models\User;
use Bishopm\Connexion\Models\Setting;
use Bishopm\Connexion\Models\Individual;
use Bishopm\Connexion\Models\Society;
use Bishopm\Connexion\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use Bishopm\Connexion\Notifications\NewUserRegistration;
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

    private $settings;   

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
            'name' => 'required|unique:users',
            'email' => 'required|email',
            'individual_id' => 'required|integer',
            'password' => 'required|min:6|confirmed',
            'service_id' => 'integer'
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
        $indiv=Individual::find($data['individual_id']);
        $indiv->service_id=$data['service_id'];
        $indiv->save();
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'individual_id' => $data['individual_id'],
            'password' => bcrypt($data['password']),
            'allow_messages' => 'Yes'
        ]);
    }

    public function showRegistrationForm()
    {
        $individuals=array();
        $socname=Setting::where('setting_key','society_name')->first()->setting_value;
        $society=Society::with('services')->where('society',$socname)->first();
        return view('connexion::auth.register',compact('individuals','society'));
    }

    /**
    * Handle a registration request for the application.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        $settings=Setting::where('setting_key','site_abbreviation')->first();
        $indiv=Individual::find($request->input('individual_id'));
        $message=$indiv->firstname . " " . $indiv->surname . " has successfully registered as a user on the " . $settings->setting_value . " website. You may want to give their profile additional permissions?";
        $admin=User::find(1);
        $admin->notify(new NewUserRegistration($message));
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        event(new Registered($user));
        $webrole=Role::where('slug','web-user')->first()->id;
        $user->roles()->attach($webrole);
        $this->guard()->login($user);
        UserVerification::generate($user);
        UserVerification::send($user, 'Welcome!');
        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

}
