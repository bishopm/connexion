<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\ServicetypesRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateServicetypeRequest;
use Bishopm\Connexion\Http\Requests\UpdateServicetypeRequest;

class ServicetypesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $servicetype;
    private $settings;

    public function __construct(ServicetypesRepository $servicetype, SettingsRepository $settings)
    {
        $this->servicetype = $servicetype;
        $this->settings = $settings;
    }

    public function index()
    {
        $servicetypes = $this->servicetype->all();
        if ($servicetypes=="No valid url") {
            return redirect()->route('admin.settings.index')->with('notice', 'Please ensure that the API url is correctly specified');
        } else {
            return view('connexion::servicetypes.index', compact('servicetypes'));
        }
    }

    public function edit($id)
    {
        $data['circuit'] = $this->settings->getkey('circuit');
        $data['servicetype']=$this->servicetype->find($id);
        return view('connexion::servicetypes.edit', $data);
    }

    public function create()
    {
        $data['circuit'] = $this->settings->getkey('circuit');
        return view('connexion::servicetypes.create', $data);
    }

    public function show($id)
    {
        $data['servicetype']=$this->servicetype->find($id);
        return view('connexion::servicetypes.show', $data);
    }

    public function store(CreateServicetypeRequest $request)
    {
        $this->servicetype->create($request->except('image', 'token'));

        return redirect()->route('admin.servicetypes.index')
            ->withSuccess('New service type added');
    }
    
    public function update($id, UpdateServicetypeRequest $request)
    {
        $this->servicetype->update($id, $request->except('image', 'token'));
        return redirect()->route('admin.servicetypes.index')->withSuccess('Service type has been updated');
    }

    public function destroy($servicetype)
    {
        $this->servicetype->destroy($servicetype);
        return redirect()->route('admin.servicetypes.index')->withSuccess('Service type has been deleted');
    }
}
