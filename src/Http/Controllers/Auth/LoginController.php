<?php

namespace Bishopm\Connexion\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Socialite;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    private $setting;

    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SettingsRepository $setting)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->setting = $setting;
    }

    public function redirectTo()
    {
        return back()->getTargetUrl();
    }

    public function showLoginForm()
    {
        $churchname = $this->setting->getkey('site_name');
        return view('connexion::auth.login', compact('churchname'));
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }

    public function username()
    {
        return 'name';
    }

    protected function getFailedLoginMessage()
    {
        return 'YourCustomMessage';
    }


    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }
 
    public function handleProviderCallback($social)
    {
        $userSocial = Socialite::driver($social)->user();
        if ($social=="facebook") {
            $user = User::where(['facebook_id' => $userSocial->getId()])->first();
            $provider_id=$userSocial->getId();
        } else {
            $user = User::where(['google_id' => $userSocial->id])->first();
            $provider_id=$userSocial->id;
        }
        if ($user) {
            Auth::login($user);
            return redirect('/');
        } else {
            $individuals=array();
            $services=explode(',', $this->setting->getkey('worship_services'));
            return view('connexion::auth.register', ['name' => $userSocial->getName(), 'email' => $userSocial->getEmail(), 'individuals'=>$individuals, 'services'=>$services, 'provider'=>$social, 'provider_id'=>$provider_id]);
        }
    }
}
