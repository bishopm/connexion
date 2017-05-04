<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SlideshowsRepository;
use Bishopm\Connexion\Models\Slideshow;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSlideshowRequest;
use Bishopm\Connexion\Http\Requests\UpdateSlideshowRequest;

class SlideshowsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $slideshow;

	public function __construct(SlideshowsRepository $slideshow)
    {
        $this->slideshow = $slideshow;
    }

	public function index()
	{
        $slideshows = $this->slideshow->all();
   		return view('connexion::slideshows.index',compact('slideshows'));
	}

	public function edit(Slideshow $slideshow)
    {
        return view('connexion::slideshows.edit', compact('slideshow'));
    }

    public function create()
    {
        return view('connexion::slideshows.create');
    }

	public function show(Slideshow $slideshow)
	{
        $data['slideshow']=$slideshow;
        return view('connexion::slideshows.show',$data);
	}

    public function store(CreateSlideshowRequest $request)
    {
        $slideshow=$this->slideshow->create($request->all());
        return redirect()->route('admin.slideshows.index')
            ->withSuccess('New slideshow added');
    }
	
    public function update(Slideshow $slideshow, UpdateSlideshowRequest $request)
    {
        $this->slideshow->update($slideshow, $request->all());
        return redirect()->route('admin.slideshows.index')->withSuccess('Slideshow has been updated');
    }

}