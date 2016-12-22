<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\SermonsRepository;
use bishopm\base\Models\Sermon;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateSermonRequest;
use bishopm\base\Http\Requests\UpdateSermonRequest;

class SermonsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $sermon;

	public function __construct(SermonsRepository $sermon)
    {
        $this->sermon = $sermon;
    }

	public function edit($series,Sermon $sermon)
    {
        return view('base::sermons.edit', compact('sermon','series'));
    }

    public function create($series_id)
    {
        return view('base::sermons.create',compact('series_id'));
    }

	public function show(Sermon $sermon)
	{
        $data['sermon']=$sermon;
        return view('base::sermons.show',$data);
	}

    public function store(CreateSermonRequest $request)
    {
        $this->sermon->create($request->all());

        return redirect()->route('admin.series.show',$request->series_id)
            ->withSuccess('New sermon added');
    }
	
    public function update(Sermon $sermon, UpdateSermonRequest $request)
    {
        $this->sermon->update($sermon, $request->all());
        return redirect()->route('admin.sermons.index')->withSuccess('Sermon has been updated');
    }

}