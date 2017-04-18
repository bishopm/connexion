<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SlidesRepository;
use Bishopm\Connexion\Models\Slide;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSlideRequest;
use Bishopm\Connexion\Http\Requests\UpdateSlideRequest;

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
        return view('connexion::slides.edit', compact('slide'));
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
        $slide=$this->slide->create($request->all());
        return redirect()->route('admin.slides.index')
            ->withSuccess('New slide added');
    }
	
    public function update(Slide $slide, UpdateSlideRequest $request)
    {
        $this->slide->update($slide, $request->all());
        return redirect()->route('admin.slides.index')->withSuccess('Slide has been updated');
    }

}