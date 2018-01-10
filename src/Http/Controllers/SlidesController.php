<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SlidesRepository;
use Bishopm\Connexion\Models\Slide;
use Bishopm\Connexion\Models\Slideshow;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSlideRequest;
use Bishopm\Connexion\Http\Requests\UpdateSlideRequest;

class SlidesController extends Controller
{

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
        return view('connexion::slides.index', compact('slides'));
    }

    public function edit(Slideshow $slideshow, Slide $slide)
    {
        return view('connexion::slides.edit', compact('slide', 'slideshow'));
    }

    public function create(Slideshow $slideshow)
    {
        return view('connexion::slides.create', compact('slideshow'));
    }

    public function show(Slide $slide)
    {
        $data['slide']=$slide;
        return view('connexion::slides.show', $data);
    }

    public function store(CreateSlideRequest $request)
    {
        $slide=$this->slide->create($request->all());
        return redirect()->route('admin.slideshows.show', $request->input('slideshow_id'))
            ->withSuccess('New slide added');
    }
    
    public function update(Slide $slide, UpdateSlideRequest $request)
    {
        $this->slide->update($slide, $request->all());
        return redirect()->route('admin.slideshows.show', $request->input('slideshow_id'))->withSuccess('Slide has been updated');
    }

    public function destroy($id)
    {
        $slide=$this->slide->find($id);
        $slideshow=$slide->slidehow_id;
        $slide->delete();
        return redirect()->route('admin.slideshows.show', $slideshow)->withSuccess('Slide has been deleted');
    }
}
