<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\ResourcesRepository;
use bishopm\base\Models\Resource;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateResourceRequest;
use bishopm\base\Http\Requests\UpdateResourceRequest;

class ResourcesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $resource;

	public function __construct(ResourcesRepository $resource)
    {
        $this->resource = $resource;
    }

	public function index()
	{
        $resources = $this->resource->all();
   		return view('base::resources.index',compact('resources'));
	}

	public function edit(Resource $resource)
    {
        return view('base::resources.edit', compact('resource'));
    }

    public function create()
    {
        return view('base::resources.create');
    }

	public function show(Resource $resource)
	{
        $data['resource']=$resource;
        return view('base::resources.show',$data);
	}

    public function store(CreateResourceRequest $request)
    {
        $this->resource->create($request->all());

        return redirect()->route('admin.resources.index')
            ->withSuccess('New resource added');
    }
	
    public function update(Resource $resource, UpdateResourceRequest $request)
    {
        $this->resource->update($resource, $request->all());
        return redirect()->route('admin.resources.index')->withSuccess('Resource has been updated');
    }

}