<?php

namespace Bishopm\Connexion\Http\Controllers\Web;

use Bishopm\Connexion\Repositories\StatisticsRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Statistic;
use Bishopm\Connexion\Models\Setting;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateStatisticRequest;
use Bishopm\Connexion\Http\Requests\UpdateStatisticRequest;
use Bishopm\Connexion\Charts\ChurchattendanceChart;

class StatisticsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $statistic;
    private $setting;

    public function __construct(StatisticsRepository $statistic, SettingsRepository $setting)
    {
        $this->statistic = $statistic;
        $this->setting = $setting;
        $this->servicetimes = explode(',', $this->setting->getkey('worship_services'));
    }

    public function index()
    {
        $servicetimes=$this->servicetimes;
        $stats=Statistic::orderBy('statdate')->get();
        if (count($stats)) {
            foreach ($stats as $stat) {
                $statistics[$stat->statdate][$stat->servicetime]['attendance']=$stat->attendance;
                $statistics[$stat->statdate][$stat->servicetime]['id']=$stat->id;
            }
            return view('connexion::statistics.index', compact('statistics', 'servicetimes'));
        } else {
            return redirect()->route('dashboard')->with('notice', 'You need to add a service before recording statistics');
        }
    }

    public function edit($id)
    {
        $services=$this->servicetimes;
        $statistic=$this->statistic->find($id);
        return view('connexion::statistics.edit', compact('statistic', 'services'));
    }

    public function create()
    {
        $services=$this->servicetimes;
        return view('connexion::statistics.create', compact('services'));
    }

    public function show()
    {
        $data['statistic']=$statistic;
        return view('connexion::statistics.show', $data);
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

    public function showhistory($service, $years=3)
    {
        $colors=array('red','blue','green','orange','lightblue');
        $lastyear=date('Y');
        $firstyear=$lastyear-$years+1;
        $stats=Statistic::where('servicetime', $service)->where('included', 1)->where('statdate', '>=', $firstyear . '-01-01')->where('statdate', '<=', $lastyear . '-12-31')->orderBy('statdate')->get();
        $fin=array();
        $wrk=array();
        foreach ($stats as $stat) {
            $yy=date('Y', strtotime($stat->statdate));
            $fin[$yy][]=$stat->attendance;
            if (!array_key_exists($yy, $wrk)) {
                $wrk[$yy]['tot']=0;
                $wrk[$yy]['count']=0;
            }
            $wrk[$yy]['tot']=$wrk[$yy]['tot']+$stat->attendance;
            $wrk[$yy]['count']++;
        }
        $data['chart'] = new ChurchattendanceChart;
        $data['chart']->borderColor = ['green','red','blue'];
        $data['chart']->title("Service attendance: " . $firstyear . " - " . $lastyear);
        $maxi=0;
        foreach ($fin as $k=>$f) {
            if ($wrk[$k]['count']>$maxi) {
                $maxi=$wrk[$k]['count'];
            }
        }
        $maxi=$maxi-1;
        foreach (range(0, $maxi) as $num) {
            foreach ($fin as $kkk=>$fff) {
                if (!array_key_exists($num, $fin[$kkk])) {
                    $fin[$kkk][$num]=round($wrk[$kkk]['tot']/$wrk[$kkk]['count']);
                }
            }
        }
        foreach ($fin as $k2=>$f2) {
            $data['chart']->dataset($k2 . " (" . round($wrk[$k2]['tot']/$wrk[$k2]['count']) . ")", 'line', $f2)->options(['color' => '#ff0000']);
        }
        $data['chart']->labels(range(0, $maxi));
        $data['service']=$service;
        foreach ($data['chart']->datasets as $ndx=>$ds) {
            $ds->color($colors[$ndx]);
            $ds->backgroundColor($colors[$ndx]);
            $ds->fill(false);
        }
        return view('connexion::statistics.history', $data);
    }

    public function showgraph($year="")
    {
        $colors=array('red','blue','green','orange','lightblue');
        if (!$year) {
            $year=date('Y');
        }
        $services=$this->servicetimes;
        $data=Statistic::whereIn('servicetime', $services)->where('included', 1)->where('statdate', '>=', $year . '-01-01')->where('statdate', '<=', $year . '-12-31')->get();
        $working=array();
        $allyears=array();
        $fin=array();
        $averages=array();
        foreach ($data as $stat) {
            $allyears[]=date('Y', strtotime($stat->statdate));
            $weeks[]=strtotime($stat->statdate);
            if (!array_key_exists($stat->servicetime, $working)) {
                $working[$stat->servicetime]['total']=0;
                $working[$stat->servicetime]['count']=0;
            }
            $working[$stat->servicetime]['total']=$working[$stat->servicetime]['total']+$stat->attendance;
            $working[$stat->servicetime]['count']=$working[$stat->servicetime]['count']+1;
            $fin[$stat->servicetime][strtotime($stat->statdate)]=$stat->attendance;
        }
        $avgtot=0;
        foreach ($working as $kkk=>$aaa) {
            $averages[$kkk]['avg']=intval(round($aaa['total']/$aaa['count'], 0));
            $avgtot = $avgtot + $aaa['total']/$aaa['count'];
        }
        $avgtot=intval(round($avgtot), 0);
        ksort($fin);
        asort($weeks);
        $allweeks=array_unique($weeks);
        $totals=array();
        foreach ($allweeks as $wk) {
            foreach ($fin as $kk=>$ff) {
                if (!array_key_exists($wk, $ff)) {
                    $fin[$kk][$wk]=$averages[$kk]['avg'];
                    $ff[$wk]=$averages[$kk]['avg'];
                }
                if (!array_key_exists($wk, $totals)) {
                    $totals[$wk]=$ff[$wk];
                } else {
                    $totals[$wk]=$totals[$wk]+$ff[$wk];
                }
            }
            $labels[]=date('j M', $wk);
        }
        if (count($fin)>1) {
            $fin['total']=$totals;
        }
        $datum=array();
        foreach ($fin as $key=>$final) {
            ksort($final);
            foreach ($final as $dat) {
                $datum[$key][]=$dat;
            }
        }
        $data['chart'] = new ChurchattendanceChart;
        $data['chart']->title("Service attendance: " . $year);
        foreach ($datum as $k=>$f) {
            if ($k!=="total") {
                $data['chart']->dataset($k . " (" . $averages[$k]['avg'] . ")", 'line', $f);
            } else {
                $data['chart']->dataset("Total (" . $avgtot . ")", 'line', $f);
            }
        }
        $data['chart']->labels($labels);
        $alldat=Statistic::whereIn('servicetime', $services)->get();
        foreach ($alldat as $ad) {
            $allyears[]=date('Y', strtotime($ad->statdate));
        }
        $allyears=array_unique($allyears);
        asort($allyears);
        $allyears=array_flatten($allyears);
        $thisyr=array_search($year, $allyears);
        if ($thisyr>0) {
            $data['lastyr']=$allyears[$thisyr-1];
        } else {
            $data['lastyr']="";
        }
        if ($thisyr<count($allyears)-1) {
            $data['nextyr']=$allyears[$thisyr+1];
        } else {
            $data['nextyr']="";
        }
        foreach ($data['chart']->datasets as $ndx=>$ds) {
            $ds->color($colors[$ndx]);
            $ds->backgroundColor($colors[$ndx]);
            $ds->fill(false);
        }
        $data['thisyr']=$year;
        return view('connexion::statistics.graph', $data);
    }

    public function destroy($id)
    {
        $stat=$this->statistic->find($id);
        $stat->delete();
        return redirect()->route('admin.statistics.index')->withSuccess('Statistic has been deleted');
    }
}
