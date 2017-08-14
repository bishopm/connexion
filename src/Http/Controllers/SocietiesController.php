<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SocietiesRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Society;
use Bishopm\Connexion\Models\Setting;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSocietyRequest;
use Bishopm\Connexion\Http\Requests\UpdateSocietyRequest;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class SocietiesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    private $society,$setting;

	public function __construct(SettingsRepository $setting, SocietiesRepository $society)
    {
        $this->client = new Client();
        $this->setting=$setting;
        $this->society = $society;
        if (filter_var($this->setting->getkey('church_api_url'), FILTER_VALIDATE_URL)) { 
            $this->api_url = $this->setting->getkey('church_api_url');   
            $this->circuits = self::circuits();
        } else {
            $this->api_url="";
        }
    }

    public function circuits(){
        return json_decode($this->client->request('GET', $this->api_url . '/circuits')->getBody()->getContents());
    }

	public function index()
	{
        if ($this->api_url){
            $circuits = $this->circuits;
            $societies = $this->society->all();
            return view('connexion::societies.index',compact('societies','circuits'));
        } else {
            return redirect()->route('admin.settings.index')->withNotice('A valid url needs to be set to use the API');
        }
	}

	public function edit(Society $society)
    {
        return view('connexion::societies.edit', compact('society'));
    }

    public function create()
    {
        return view('connexion::societies.create');
    }

	public function show($society)
	{
        $data['society']=$this->society->find($society);
        return view('connexion::societies.show',$data);
	}

    public function store(CreateSocietyRequest $request)
    {
        $soc=$this->society->create($request->all());

        return redirect()->route('admin.societies.show',$soc->id)
            ->withSuccess('New society added');
    }
	
    public function update(Society $society, UpdateSocietyRequest $request)
    {
        $this->society->update($society, $request->all());
        return redirect()->route('admin.societies.index')->withSuccess('Society has been updated');
    }

    public function destroy(Society $society)
    {
        $this->society->destroy($society);
        return view('connexion::societies.index')->withSuccess('The ' . $society->society . ' society has been deleted');
    }

}