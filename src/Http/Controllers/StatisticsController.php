<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\StatisticsRepository;
use Bishopm\Connexion\Models\Statistic;
use Bishopm\Connexion\Models\Setting;
use Bishopm\Connexion\Models\Society;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateStatisticRequest;
use Bishopm\Connexion\Http\Requests\UpdateStatisticRequest;

class StatisticsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $statistic;

	public function __construct(StatisticsRepository $statistic)
    {
        $this->statistic = $statistic;
    }

	public function index()
	{
        $socname=Setting::where('setting_key','society_name')->first()->setting_value;
        $society=Society::with('services')->where('society',$socname)->first();
        $services=$society->services;
        foreach ($services as $service){
            foreach ($service->statistics as $stat){
                $statistics[$stat->statdate][$service->servicetime]=$stat->attendance;
            }
            $servicetimes[]=$service->servicetime;
        }
        asort($servicetimes);
   		return view('connexion::statistics.index',compact('statistics','servicetimes'));
	}

	public function edit()
    {
        return view('connexion::statistics.edit', compact('statistic','society'));
    }

    public function create()
    {
        return view('connexion::statistics.create',compact('society'));
    }

	public function show()
	{
        $data['statistic']=$statistic;
        return view('connexion::statistics.show',$data);
	}

    public function store()
    {
        $request->request->add(['society_id' => $society]);
        $this->statistic->create($request->all());

        return redirect()->route('admin.societies.show',$society)
            ->withSuccess('New statistic added');
    }
	
    public function update()
    {
        $request->request->add(['society_id' => $society]);
        $this->statistic->update($statistic, $request->all());
        return redirect()->route('admin.societies.show',$society)->withSuccess('Statistic has been updated');
    }

}