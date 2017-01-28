<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\ServicesRepository;
use Bishopm\Connexion\Models\Service;
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

	public function __construct(ServicesRepository $service)
    {
        $this->service = $service;
    }

	public function index()
	{
        $services = $this->service->all();
   		return view('connexion::services.index',compact('services'));
	}

	public function edit($society,Service $service)
    {
        return view('connexion::services.edit', compact('service','society'));
    }

    public function create($society)
    {
        return view('connexion::services.create',compact('society'));
    }

	public function show(Service $service)
	{
        $data['service']=$service;
        return view('connexion::services.show',$data);
	}

    public function store($society,CreateServiceRequest $request)
    {
        $request->request->add(['society_id' => $society]);
        $this->service->create($request->all());

        return redirect()->route('admin.societies.show',$society)
            ->withSuccess('New service added');
    }
	
    public function update($society, Service $service, UpdateServiceRequest $request)
    {
        $request->request->add(['society_id' => $society]);
        $this->service->update($service, $request->all());
        return redirect()->route('admin.societies.show',$society)->withSuccess('Service has been updated');
    }

}