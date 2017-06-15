<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\StatisticsRepository;
use Bishopm\Connexion\Models\Statistic;
use Bishopm\Connexion\Models\Setting;
use Bishopm\Connexion\Models\Society;
use Bishopm\Connexion\Models\Service;
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
        $soc=$society->id;
        $services=$society->services;
        $statistics=array();
        if (count($services)){
            foreach ($services as $service){
                foreach ($service->statistics as $stat){
                    $statistics[$stat->statdate][$service->servicetime]['attendance']=$stat->attendance;
                    $statistics[$stat->statdate][$service->servicetime]['id']=$stat->id;
                }
                $servicetimes[]=$service->servicetime;
            }
            asort($servicetimes);
            return view('connexion::statistics.index',compact('statistics','servicetimes','soc','society'));
        } else {
            return redirect()->route('admin.societies.show',$soc)->with('notice','You need to add a service before recording statistics');
        }
	}

	public function edit($id)
    {
        $socname=Setting::where('setting_key','society_name')->first()->setting_value;
        $society=Society::with('services')->where('society',$socname)->first();
        $soc=$society->id;
        $services=$society->services;
        $statistic=$this->statistic->find($id);
        return view('connexion::statistics.edit', compact('statistic','services'));
    }

    public function create($soc)
    {
        $services=Service::where('society_id',$soc)->get();
        return view('connexion::statistics.create',compact('services'));
    }

	public function show()
	{
        $data['statistic']=$statistic;
        return view('connexion::statistics.show',$data);
	}

    public function store(CreateStatisticRequest $request)
    {
        $this->statistic->create($request->all());

        return redirect()->route('admin.statistics.index')
            ->withSuccess('New statistic added');
    }
	
    public function update(Statistic $statistic, UpdateStatisticRequest $request)
    {
        $this->statistic->update($statistic, $request->all());
        return redirect()->route('admin.statistics.index')->withSuccess('Statistic has been updated');
    }

}