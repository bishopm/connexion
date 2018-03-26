<?php

namespace Bishopm\Connexion\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use DB;
use Mail;
use App\Http\Requests;
use View;
use Bishopm\Connexion\Libraries\Fpdf\Fpdf;
use Bishopm\Connexion\Http\Requests\CreateSetRequest;
use Bishopm\Connexion\Http\Requests\UpdateSetRequest;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Models\Song;
use Bishopm\Connexion\Models\Individual;
use Bishopm\Connexion\Models\Setitem;
use Bishopm\Connexion\Models\Set;
use Bishopm\Connexion\Models\Roster;
use Bishopm\Connexion\Models\Society;
use Bishopm\Connexion\Models\Setting;
use Bishopm\Connexion\Models\Group;
use Bishopm\Connexion\Models\User;
use Bishopm\Connexion\Notifications\WorshipSetNotification;
use Bishopm\Connexion\Repositories\SettingsRepository;

class SetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $setting;

    public function __construct(SettingsRepository $setting)
    {
        $this->setting = $setting;
    }

    public function index()
    {
        $sets=Set::orderBy('servicedate')->get();
        if (count($sets)) {
            foreach ($sets as $set) {
                $finsets[strtotime($set->servicedate)][$set->servicetime]=$set->id;
                $services[]=$set->servicetime;
                $servicedates[]=strtotime($set->servicedate);
            }
            foreach (array_unique($servicedates) as $sd) {
                foreach (array_unique($services) as $ss) {
                    if (!array_key_exists($ss, $finsets[$sd])) {
                        $finsets[$sd][$ss]="";
                    }
                }
                ksort($finsets[$sd]);
            }
            $data['sets']=$finsets;
            $data['services']=array_unique($services);
            asort($data['services']);
        } else {
            $data['sets']=array();
            $data['services']=array();
        }
        return view('connexion::sets.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data['sunday']=date("Y-m-d", strtotime("next Sunday"));
        $data['services']=explode(',', $this->setting->getkey('worship_services'));
        if (!count($data['services'])) {
            return redirect()->route('admin.societies.index')->with('notice', 'At least one service must be added before adding a set. Click a society below to add a new service');
        }
        return view('connexion::sets.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(CreateSetRequest $request)
    {
        $checkset=Set::where('servicedate', '=', $request->servicedate)->where('servicetime', '=', $request->servicetime)->first();
        if (count($checkset)) {
            $set=$checkset;
        } else {
            $set=Set::create($request->all());
        }
        return redirect()->route('admin.sets.index')->withSuccess('New set added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data['items']=Setitem::with('song', 'set')->where('set_id', '=', $id)->get();
        $allids=array();
        foreach ($data['items'] as $item) {
            if ($item->song_id>0) {
                $allids[]=$item->song->id;
            }
        }
        $data['set']=Set::find($id);
        if (count($allids)) {
            $data['songs']=Song::whereNotIn('id', $allids)->orderBy('title')->select('title', 'id')->get();
        } else {
            $data['songs']=Song::orderBy('title')->select('title', 'id')->get();
        }
        return view('connexion::sets.show', $data);
    }

    public function showapi($id)
    {
        $data['set']=Set::find($id);
        $data['service']=$data['set']->service->service;
        $items=Setitem::with('song', 'set')->where('set_id', '=', $id)->orderBy('itemorder')->get();
        $data['songs']=array();
        $allids=array();
        foreach ($items as $item) {
            $dum['title']=$item->song->title;
            $dum['id']=$item->id;
            //$dum['url']=url('/') . "/admin/worship/songs/" . $item->id;
            $data['songs'][]=$dum;
            $allids[]=$item->song->id;
        }
        if (count($allids)) {
            $data['newsongs']=Song::whereNotIn('id', $allids)->orderBy('title')->select('title', 'id')->get();
        } else {
            $data['newsongs']=Song::orderBy('title')->select('title', 'id')->get();
        }
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
    }

    public function order($id)
    {
        $roster=Roster::find($this->setting->getkey('sunday_roster'));
        $set=Set::find($id);
        if (count($roster)) {
            $services=explode(',', $roster->subcategories);
            if (in_array($set->servicetime, $services)) {
                $readersgroup=Group::where('groupname', '=', 'Readers ' . $set->servicetime)->first();
                $readerid=DB::table('group_individual_roster')->where('group_id', $readersgroup->id)->where('roster_id', $roster->id)->where('rosterdate', $set->servicedate)->first();
                if ($readerid) {
                    $reader=Individual::find($readerid->individual_id);
                    $readername=$reader->firstname . " " . $reader->surname;
                }
                $stewardsgroup=Group::where('groupname', '=', 'Society Stewards')->first();
                $stewardid=DB::table('group_individual_roster')->where('group_id', $stewardsgroup->id)->where('roster_id', $roster->id)->where('rosterdate', $set->servicedate)->first();
                if ($stewardid) {
                    $steward=Individual::find($stewardid->individual_id);
                    $stewardname=$steward->firstname . " " . $steward->surname;
                }
            }
        }
        $items=Setitem::where('set_id', '=', $id)->orderBy('itemorder')->get();
        $pdf = new Fpdf();
        $pdf->AddPage('L');
        for ($i = 0; $i <= 1; $i++) {
            $y=45;
            $x=153*$i;
            //$pdf->line(150, 10, 150, 200);
            $logopath=base_path() . '/public/vendor/bishopm/images/logo.png';
            $pdf->SetFont('Arial', '', 9);
            $pdf->Image($logopath, 10+$x, 10, 0, 21);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->setxy(55+$x, 24);
            $pdf->cell(82, 0, date("j M Y", strtotime($set->servicedate)), 0, 0, 'R');
            $pdf->setxy(55+$x, 30);
            $pdf->cell(82, 0, $set->servicetime . " service", 0, 0, 'R');
            $pdf->line(10+$x, 35, 135+$x, 35);
            $pdf->SetFont('Arial', '', 12);
            foreach ($items as $item) {
                if ($item->itemtype=='song') {
                    $title=Song::find($item->song_id)->title;
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->text(10+$x, $y, $title);
                    $pdf->SetFont('Arial', '', 12);
                } else {
                    $title=$item->description;
                    if ($item->itemtype=="reading") {
                        $title="Reading: " . $title;
                        if (isset($readername)) {
                            $title.=" (" . $readername . ")";
                        }
                    } elseif ($item->itemtype=="welcome") {
                        $title="Welcome";
                        if (isset($stewardname)) {
                            $title.=": " . $stewardname;
                        }
                    } elseif ($item->description=="") {
                        $title=ucfirst($item->itemtype);
                    } else {
                        $title=$item->description;
                    }
                    $pdf->text(10+$x, $y, $title);
                }
                $y=$y+8;
            }
        }
        $pdf->Output();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function update($id, UpdateSetRequest $request)
    {
    }

    public function updateapi($id, Request $request)
    {
        $items=$request->all();
        foreach ($items as $key=>$item) {
            $id=$item['id'];
            $dum=Setitem::find($id);
            $dum->itemorder=$key;
            $dum->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
    }

    public function sendEmail(Request $request)
    {
        $admin_id=$this->setting->getkey('worship_administrator');
        $admin=User::find($admin_id);
        $message = nl2br($request->message);
        $sender=auth()->user();
        $admin->notify(new WorshipSetNotification($message));
        $sender->notify(new WorshipSetNotification($message));
        return redirect(url('/admin/worship') . '/sets')->withSuccess('Set details have been sent to ' . $admin->individual->firstname . ' and copied to you');
    }
}
