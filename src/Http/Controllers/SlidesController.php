<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\SlidesRepository;
use bishopm\base\Models\Slide;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateSlideRequest;
use bishopm\base\Http\Requests\UpdateSlideRequest;
use MediaUploader;

class SlidesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $slide;

	public function __construct(SlidesRepository $slide)
    {
        $this->slide = $slide;
    }

	public function index()
	{
        $slides = $this->slide->all();
   		return view('base::slides.index',compact('slides'));
	}

	public function edit(Slide $slide)
    {
        $media=$slide->getMedia('image')->first();
        return view('base::slides.edit', compact('slide','media'));
    }

    public function create()
    {
        return view('base::slides.create');
    }

	public function show(Slide $slide)
	{
        $data['slide']=$slide;
        return view('base::slides.show',$data);
	}

    public function store(CreateSlideRequest $request)
    {
        $slide=$this->slide->create($request->except('image'));
        if ($request->file('image')){
            $fname=$slide->id;
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('slides')->useFilename($fname)->upload();
            $slide->attachMedia($media, 'image');
        }
        return redirect()->route('admin.slides.index')
            ->withSuccess('New slide added');
    }
	
    public function update(Slide $slide, UpdateSlideRequest $request)
    {
        $this->slide->update($slide, $request->except('image'));
        if ($request->file('image')){
            $fname=$slide->id;
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('slides')->useFilename($fname)->upload();
            $slide->attachMedia($media, 'image');
        }        
        return redirect()->route('admin.slides.index')->withSuccess('Slide has been updated');
    }

    public function removemedia(Slide $slide)
    {
        $media = $slide->getMedia('image');
        $slide->detachMedia($media);
    }

}