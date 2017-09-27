<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\ServicesRepository;
use Bishopm\Connexion\Repositories\SocietiesRepository;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateServiceRequest;
use Bishopm\Connexion\Http\Requests\UpdateServiceRequest;

class ServicesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $service;

	public function __construct(ServicesRepository $service, SocietiesRepository $society)
    {
        $this->service = $service;
        $this->society = $society;
    }

	public function index()
	{
        $services = $this->service->all();
   		return view('connexion::services.index',compact('services'));
	}

	public function edit($soc,$serv)
    {
        $service = $this->service->find($serv);
        $society = $this->society->find($soc);
        return view('connexion::services.edit', compact('service','society'));
    }

    public function create($soc)
    {
        $society = $this->society->find($soc);
        return view('connexion::services.create',compact('society'));
    }

	public function show($ser)
	{
        $data['service']=$this->service->find($ser);
        return view('connexion::services.show',$data);
	}

    public function store($society,CreateServiceRequest $request)
    {
        $request->request->add(['society_id' => $society]);
        $this->service->create($request->all());

        return redirect()->route('admin.societies.show',$society)
            ->withSuccess('New service added');
    }
	
    public function update($society, $service, UpdateServiceRequest $request)
    {
        $request->request->add(['society_id' => $society]);
        $this->service->update($service, $request->all());
        return redirect()->route('admin.societies.show',$society)->withSuccess('Service has been updated');
    }

}