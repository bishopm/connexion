<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SeriesRepository;
use Bishopm\Connexion\Models\Series;
use Bishopm\Connexion\Models\Individual;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSeriesRequest;
use Bishopm\Connexion\Http\Requests\UpdateSeriesRequest;

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
        return view('connexion::series.edit', compact('series'));
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
        $request->request->add(['created_at' => $request->input('created_at') . "12:00:00"]);
        $series=$this->series->create($request->all());
        return redirect()->route('admin.series.index')->withSuccess('New series added');
    }
	
    public function update(Series $series, UpdateSeriesRequest $request)
    {
        $request->request->add(['created_at' => $request->input('created_at') . "12:00:00"]);
        $this->series->update($series, $request->all());
        return redirect()->route('admin.series.index')->withSuccess('Series has been updated');
    }

    public function seriesapi($id="all")
	{
        if ($id<>'all'){
            $series=$this->series->find($id);
            $series->image="http://umc.org.za/public/storage/series/" . $series->image;
        } else {
            $series = $this->series->allwithsermons();
            foreach ($series as $seri){
                $seri->image="http://umc.org.za/public/storage/series/" . $seri->image;
                foreach ($seri->sermons as $sermon){
                    $preacher=Individual::find($sermon->individual_id);
                    $sermon->preacher=$preacher->firstname . " " . $preacher->surname;
                }
            }
        }
        return $series;
	}

}