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
        $media=$series->getMedia('image')->first()->getUrl();
        return view('connexion::series.edit', compact('series','media'));
    }

    public function create()
    {
        $media='';
        return view('connexion::series.create',compact('media'));
    }

	public function show(Series $series)
	{
        $data['series']=$series;
        return view('connexion::series.show',$data);
	}

    public function store(CreateSeriesRequest $request)
    {
        $request->request->add(['created_at' => $request->input('created_at') . "12:00:00"]); 
        $series=$this->series->create($request->except('image'));
        $fname=explode('.',$request->input('image'));
        $media = MediaUploader::import('public', 'series', $fname[0], $fname[1]);
        $series->attachMedia($media, 'image');
        return redirect()->route('admin.series.index')
            ->withSuccess('New series added');
    }
	
    public function update(Series $series, UpdateSeriesRequest $request)
    {
        $request->request->add(['created_at' => $request->input('created_at') . "12:00:00"]);
        if ($series->firstMedia->filename . '.' . $series->firstMedia->extension <> $request->input('image')){
            $series->detachMedia($series->media);
            // New image
            $fname=explode('.',$request->input('image'));
            $media=Media::where('disk','=','public')->where('directory','=','series')->where('filename','=',$fname[0])->where('extension','=',$fname[1])->firstOrFail();
            if (!$media){
                $media = MediaUploader::import('public', 'series', $fname[0], $fname[1]);
            }
            $series->attachMedia($media, 'image');
        } 
        $this->series->update($series, $request->except('image'));
        return redirect()->route('admin.series.index')->withSuccess('Series has been updated');
    }

    public function removemedia(Series $series)
    {
        $media = $series->getMedia('image');
        $series->detachMedia($media);
    }

}