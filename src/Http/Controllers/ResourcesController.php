<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\ResourcesRepository;
use bishopm\base\Models\Resource;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateResourceRequest;
use bishopm\base\Http\Requests\UpdateResourceRequest;
use MediaUploader;

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
        $media=$resource->getMedia('image')->first();
        return view('base::resources.edit', compact('resource','media'));
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
        $resource=$this->resource->create($request->except('image'));
        if ($request->file('image')){
            $fname=$resource->id;
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('resources')->useFilename($fname)->upload();
            $resource->attachMedia($media, 'image');
        }
        return redirect()->route('admin.resources.index')
            ->withSuccess('New resource added');
    }
	
    public function update(Resource $resource, UpdateResourceRequest $request)
    {
        $this->resource->update($resource, $request->except('image'));
        if ($request->file('image')){
            $fname=$resource->id;
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('resources')->useFilename($fname)->upload();
            $resource->attachMedia($media, 'image');
        }        
        return redirect()->route('admin.resources.index')->withSuccess('Resource has been updated');
    }

    public function removemedia(Resource $resource)
    {
        $media = $resource->getMedia('image');
        $resource->detachMedia($media);
    }

}