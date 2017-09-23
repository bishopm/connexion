<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\WeekdaysRepository;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateWeekdayRequest;
use Bishopm\Connexion\Http\Requests\UpdateWeekdayRequest;

class WeekdaysController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $weekday;

	public function __construct(WeekdaysRepository $weekday)
    {
        $this->weekday = $weekday;
    }

    public function index()
	{
        $weekdays = $this->weekday->all();
   		return view('connexion::weekdays.index',compact('weekdays'));
	}

	public function edit($id)
    {
        $weekday=$this->weekday->find($id);
        return view('connexion::weekdays.edit', compact('weekday'));
    }

    public function create()
    {
        return view('connexion::weekdays.create');
    }

	public function show(Weekday $weekday)
	{
        $data['weekday']=$weekday;
        return view('connexion::weekdays.show',$data);
	}

    public function store(CreateWeekdayRequest $request)
    {
        $data=$request->all();
        $data['servicedate']=strtotime($data['servicedate']);
        $this->weekday->create($data);

        return redirect()->route('admin.weekdays.index')
            ->withSuccess('New weekday added');
    }
	
    public function update($weekday, UpdateWeekdayRequest $request)
    {
        $data=$request->all();
        $data['servicedate']=strtotime($data['servicedate']);
        $this->weekday->update($weekday,$data);
        return redirect()->route('admin.weekdays.index')->withSuccess('Weekday has been updated');
    }

}