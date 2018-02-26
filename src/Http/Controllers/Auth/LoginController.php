<?php

namespace Bishopm\Connexion\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Bishopm\Connexion\Repositories\SettingsRepository;

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
}
