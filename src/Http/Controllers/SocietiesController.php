<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SocietiesRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Setting;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSocietyRequest;
use Bishopm\Connexion\Http\Requests\UpdateSocietyRequest;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class SocietiesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $society;
    private $setting;

    public function __construct(SettingsRepository $setting, SocietiesRepository $society)
    {
        $this->client = new Client();
        $this->setting=$setting;
        $this->society = $society;
        $this->circuit = $this->setting->getkey('circuit');
        $this->check=$this->society->check();
        if ($this->check<>"No valid url") {
            $this->api_url = $this->setting->getkey('church_api_url');
            $this->circuits = self::circuits();
        } else {
            $this->api_url="";
        }
    }

    public function circuits()
    {
        return json_decode($this->client->request('GET', $this->api_url . '/circuits')->getBody()->getContents());
    }

    public function tags()
    {
        return json_decode($this->client->request('GET', $this->api_url . '/tags')->getBody()->getContents());
    }

    public function index()
    {
        if (($this->api_url) and ($this->circuit)) {
            $circuits = $this->circuits;
            $check=$this->check;
            $societies = $this->society->all();
            return view('connexion::societies.index', compact('societies', 'circuits', 'check'));
        } else {
            return redirect()->route('admin.settings.index')->withNotice('Make sure you have the right circuit and API url set');
        }
    }

    public function edit($id)
    {
        $society=$this->society->find($id);
        return view('connexion::societies.edit', compact('society'));
    }

    public function create()
    {
        return view('connexion::societies.create');
    }

    public function show($id)
    {
        $society=$this->society->find($id);
        return view('connexion::societies.show', compact('society'));
    }

    public function store(CreateSocietyRequest $request)
    {
        $this->society->create($request->all());
        return redirect()->route('admin.societies.index')
            ->withSuccess('New society added');
    }
    
    public function update($id, UpdateSocietyRequest $request)
    {
        $this->society->update($id, $request->all());
        if ($request->deletion_type<>"") {
            $this->society->destroy($id);
            return redirect()->route('admin.societies.index')->withSuccess('Society has been deleted');
        } else {
            return redirect()->route('admin.societies.index')->withSuccess('Society has been updated');
        }
    }
}
