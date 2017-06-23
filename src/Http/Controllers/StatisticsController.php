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
use Charts;

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

    public function showgraph($society,$year=""){
        if (!$year){
            $year=date('Y');
        }
        $data=Statistic::where('statdate','>=',$year . '-01-01')->where('statdate','<=',$year . '-12-31')->get();
        $fin=array();
        foreach ($data as $stat){
            $fin[$stat->service->servicetime][intval(date('W',strtotime($stat->statdate)))]=$stat->attendance;
        }
        ksort($fin);
        //dd($fin);
        $chart = Charts::multi('line', 'material')
			->title("Service attendance: " . $year)
			->dimensions(0, 400) // Width x Height
			->template("material")
			->dataset('07h00', $fin['07h00'])
			->dataset('08h30', $fin['08h30'])
			->dataset('10h00', $fin['10h00']);
        return view('connexion::statistics.graph', ['chart' => $chart]);
    }

}