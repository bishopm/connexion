<?php

namespace Bishopm\Connexion\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use Bishopm\Connexion\Repositories\SettingsRepository;
use GuzzleHttp\Client, Auth;

class McsaController extends Controller {

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

	public function register(){
        $data['app_secret']=substr(env('APP_KEY'),0,20);
        $data['app_name']=$this->settings['site_name'];
        $data['circuit']=$this->settings['circuit'];
        $data['username']=Auth::user()->name;
        $data['email']=Auth::user()->email;
        $data['app_url']=url('/');
        $promise = $this->client->requestAsync('POST', $this->api_url . '/register',['json' => $data]);
        $promise->then(function ($response) {
            echo $response->getBody(); 
        });
        $promise->wait();
        //return view('connexion::mcsa.register');
    }
}