<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SeriesRepository;
use Bishopm\Connexion\Models\Series;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSeriesRequest;
use Bishopm\Connexion\Http\Requests\UpdateSeriesRequest;
use MediaUploader;

class SeriesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $series;

	public function __construct(SeriesRepository $series)
    {
        $this->series = $series;
    }

	public function index()
	{
        $series = $this->series->all();
   		return view('connexion::series.index',compact('series'));
	}

	public function edit(Series $series)
    {
        $media=$series->getMedia('image')->first();
        return view('connexion::series.edit', compact('series','media'));
    }

    public function create()
    {
        return view('connexion::series.create');
    }

	public function show(Series $series)
	{
        $data['series']=$series;
        return view('connexion::series.show',$data);
	}

    public function store(CreateSeriesRequest $request)
    {
        $series=$this->series->create($request->except('image'));
        if ($request->file('image')){
            $fname=$series->id;
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('series')->useFilename($fname)->upload();
            $series->attachMedia($media, 'image');
        }
        return redirect()->route('admin.series.index')
            ->withSuccess('New series added');
    }
	
    public function update(Series $series, UpdateSeriesRequest $request)
    {
        $this->series->update($series, $request->except('image'));
        if ($request->file('image')){
            $fname=$series->id;
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('series')->useFilename($fname)->upload();
            $series->attachMedia($media, 'image');
        }        
        return redirect()->route('admin.series.index')->withSuccess('Series has been updated');
    }

    public function removemedia(Series $series)
    {
        $media = $series->getMedia('image');
        $series->detachMedia($media);
    }

}