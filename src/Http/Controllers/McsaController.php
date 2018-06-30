<?php

namespace Bishopm\Connexion\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Setting;
use GuzzleHttp\Client;
use Auth;

class McsaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
     
    private $settings;

    public function __construct(SettingsRepository $settings)
    {
        $this->client = new Client();
        $this->settings=$settings->makeArray();
        $this->api_url = $this->settings['church_api_url'];
    }

    public function register()
    {
        $data['app_secret']=substr(env('APP_KEY'), 0, 20);
        $data['app_name']=$this->settings['site_name'];
        $data['circuit']=$this->settings['circuit'];
        $data['username']=Auth::user()->name;
        $data['email']=Auth::user()->email;
        $data['app_url']=url('/');
        $res = $this->client->request('POST', $this->api_url . '/register', ['json' => $data]);
        if (substr($res->getBody()->getContents(), 0, 13)=="Already taken") {
            return redirect()->route('admin.societies.index')->withNotice('Error: This circuit is already registered');
        } else {
            $res->getBody()->seek(0);
            $token=$res->getBody()->getContents();
            $tset=Setting::where('setting_key', 'church_api_token')->first();
            $tset->setting_value=$token;
            $tset->save();
            return redirect()->route('admin.societies.index')->withSuccess('You are registered to access the API and may now make changes to societies');
        }
    }
}
