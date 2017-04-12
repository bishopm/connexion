<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SlidesRepository;
use Bishopm\Connexion\Models\Slide;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSlideRequest;
use Bishopm\Connexion\Http\Requests\UpdateSlideRequest;
use MediaUploader;
use Plank\Mediable\Media;

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
   		return view('connexion::slides.index',compact('slides'));
	}

	public function edit(Slide $slide)
    {
        $media=$slide->getMedia('image')->first();
        return view('connexion::slides.edit', compact('slide','media'));
    }

    public function create()
    {
        return view('connexion::slides.create');
    }

	public function show(Slide $slide)
	{
        $data['slide']=$slide;
        return view('connexion::slides.show',$data);
	}

    public function store(CreateSlideRequest $request)
    {
        $slide=$this->slide->create($request->except('image'));
        if ($request->input('image')){
            $fname=explode('.',$request->input('image'));
            $media = MediaUploader::import('public', 'slides', $fname[0], $fname[1]);
            $slide->attachMedia($media, 'image');
        }
        return redirect()->route('admin.slides.index')
            ->withSuccess('New slide added');
    }
	
    public function update(Slide $slide, UpdateSlideRequest $request)
    {
        $this->slide->update($slide, $request->except('image'));
        if ($request->input('image')){
            $fname=explode('.',$request->input('image'));
            $media=Media::where('disk','=','public')->where('directory','=','slides')->where('filename','=',$fname[0])->where('extension','=',$fname[1])->firstOrFail();
            if (!count($media)){
                $media = MediaUploader::import('public', 'slides', $fname[0], $fname[1]);
            }
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