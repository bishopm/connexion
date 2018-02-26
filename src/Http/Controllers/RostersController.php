<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Models\Roster;
use Bishopm\Connexion\Models\Group;
use Bishopm\Connexion\Models\Society;
use View;
use DB;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Http\Requests\CreateRosterRequest;
use Bishopm\Connexion\Http\Requests\UpdateRosterRequest;
use Illuminate\Http\Request;
use Bishopm\Connexion\Libraries\SMSfunctions;
use Bishopm\Connexion\Libraries\Fpdf\Fpdf;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

class RostersController extends Controller
{
    private $individual;
    private $settings;

    public function __construct(IndividualsRepository $individual, SettingsRepository $settings)
    {
        $this->individual = $individual;
        $this->settings = $settings;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['rosters'] = Roster::orderBy('rostername')->get();
        return View::make('connexion::rosters.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data['groups'] = Group::all();
        return View::make('connexion::rosters.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateRosterRequest $request)
    {
        $roster=Roster::create($request->except('groups', 'extrainfo', 'multichoice'));
        if (count($request->extrainfo)) {
            $roster->extrainfo=implode(",", $request->extrainfo);
        } else {
            $roster->extrainfo="";
        }
        if (count($request->multichoice)) {
            $roster->multichoice=implode(",", $request->multichoice);
        } else {
            $roster->multichoice="";
        }
        $roster->save();
        if ($request->groups<>"") {
            $newgroups = array_map('intval', $request->groups);
            $roster->group()->sync($newgroups);
        }
        return Redirect::route('admin.rosters.index', $roster->id)->with('okmessage', 'New roster has been added');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data['roster'] = Roster::with(array('group' => function ($query) {
            $query->orderBy('groupname', 'asc');
        }))->find($id);
        $data['groups'] = Group::orderBy('groupname')->get();
        return View::make('connexion::rosters.show', $data);
    }

    private function _get_week_dates($yy, $mm, $dd)
    {
        if (strlen($mm)==1) {
            $mm="0" . $mm;
        }
        $daysofweek=array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
        $firstdayofmonth=$yy . "-" . $mm . "-" . "01";
        $firstdes='first ' . $daysofweek[$dd];

        if ((date("w", strtotime($firstdayofmonth))==$dd) or (date("w", strtotime($firstdayofmonth))==$dd-7)) {
            $weeks[0]=$firstdayofmonth;
        } else {
            $weeks[0]=date("Y-m-d", strtotime($firstdes, strtotime($firstdayofmonth)));
        }
        $weeks[1]=date("Y-m-d", strtotime($weeks[0])+604800);
        $weeks[2]=date("Y-m-d", strtotime($weeks[1])+604800);
        $weeks[3]=date("Y-m-d", strtotime($weeks[2])+604800);
        if (date("m", strtotime($weeks[3])+604800)==date("m", strtotime($weeks[0]))) {
            $weeks[4]=date("Y-m-d", strtotime($weeks[3])+604800);
        }
        return $weeks;
    }

    public function currentroster($rosterid)
    {
        $this->report($rosterid, date('Y'), date('m'));
    }

    public function nextroster($rosterid)
    {
        $this->report($rosterid, date('Y'), 1+intval(date('m')));
    }

    public function report($rosterid, $yy, $mm)
    {
        $pdf = new Fpdf();
        $pdf->AddPage('L');
        $logopath=base_path() . '/public/images/logo.jpg';
        $roster = Roster::with('group')->find($rosterid);
        $subcats=explode(",", $roster->subcategories);
        $weeks=self::_get_week_dates($yy, $mm, $roster->dayofweek);
        $churchname=$this->settings->getkey('site_name');
        $x=25;
        $pdf->SetAutoPageBreak(0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTitle($churchname . " - " . $roster->rostername);

        // SET UP DATA STRUCTURE
        DB::enableQueryLog();
        foreach ($weeks as $wkno=>$week) {
            foreach ($roster->group as $grp) {
                $groupin=false;
                foreach ($subcats as $skey=>$subcat) {
                    if (!$subcat) {
                        $subcat=$grp->groupname;
                    }
                    if ((strpos($grp->groupname, $subcat)) or ($subcat==$grp->groupname)) {
                        $groupin=true;
                        if ($subcat<>$grp->groupname) {
                            $shortgroup=trim(str_replace($subcat, "", $grp->groupname));
                        } else {
                            $shortgroup=$subcat;
                        }
                        $data[$week][$shortgroup][$subcat]=DB::table('group_individual_roster')->select('individual_id')->where('roster_id', '=', $rosterid)->where('rosterdate', '=', $week)->where('group_id', '=', $grp->id)->get();
                    }
                }
                if (!$groupin) {
                    $data[$week][$grp->groupname][$subcats[0]]=DB::table('group_individual_roster')->select('individual_id')->where('roster_id', '=', $rosterid)->where('rosterdate', '=', $week)->where('group_id', '=', $grp->id)->get();
                }
            }
            ksort($data[$week]);
        }
        $title=$churchname . ": " . $roster->rostername. " (" . date("F", strtotime($weeks[0])) . " " . $yy . ")";
        $pdf->setxy(10, 8);
        $pdf->cell(0, 0, $title, 0, 0, 'C');
        $first=true;
        $y=33;
        foreach ($data as $kk=>$wk) {
            // DISPLAY TOP HEADINGS
            if ($first) {
                $pdf->rect(10, 11, 275, 10, 'F');
                $first=false;
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetTextColor(255, 255, 255);
                foreach ($wk as $hh=>$vv) {
                    $pdf->setxy($x, $y-21);
                    $pdf->multicell(25, 4, $hh, 0, 'C');
                    $x=$x+32;
                }
            }
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->setxy(10, $y-6);
            $pdf->rect(10, $y-8, 275, 33);
            $pdf->cell(0, 0, date("j F Y", strtotime($kk)), 0, 0, 'C');
            $x=25;
            $veryfirst=true;
            foreach ($wk as $grp) {
                $y3=$y-2;
                if ($veryfirst) {
                    foreach ($subcats as $ssc) {
                        $pdf->setxy(10, $y3);
                        $pdf->cell(10, 0, $ssc);
                        $y3=$y3+10.5;
                    }
                    $veryfirst=false;
                }
                $pdf->SetFont('Arial', '', 9);
                $y2=$y-2;
                foreach ($grp as $kk=>$sc) {
                    foreach ($sc as $kkk=>$vv) {
                        $pdf->setxy($x, $y2);
                        $pdf->cell(25, 0, utf8_decode($this->individual->getName($vv->individual_id)), 0, 0, 'C');
                        $y2=$y2+3.5;
                    }
                    if (count($sc)<count($subcats)) {
                        $y2=$y2+3.5*(count($subcats)-count($sc));
                    }
                }
                $x=$x+32;
            }
            $y=7+$y+10*count($subcats);
        }
        $pdf->Output();
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data['roster'] = Roster::with(array('group' => function ($query) {
            $query->orderBy('groupname', 'asc');
        }))->find($id);
        if (count($data['roster']->group)<>0) {
            foreach ($data['roster']->group as $group) {
                $rostergroup[]=$group->id;
            }
            $data['rostergroup']= $rostergroup;
        }
        $data['groups'] = Group::orderBy('groupname')->get();
        if ($data['roster']->extrainfo) {
            $extra=explode(',', $data['roster']->extrainfo);
            foreach ($extra as $exx) {
                $rosterextra[]=intval($exx);
            }
            $data['rosterextra']=$rosterextra;
        } else {
            $data['rosterextra']=array();
        }
        if ($data['roster']->multichoice) {
            $multi=explode(',', $data['roster']->multichoice);
            foreach ($multi as $mul) {
                $rostermulti[]=intval($mul);
            }
            $data['rostermulti']=$rostermulti;
        } else {
            $data['rostermulti']=array();
        }
        return View::make('connexion::rosters.edit', $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateRosterRequest $request)
    {
        $roster = Roster::find($id);
        $roster->fill($request->except('groups', 'extrainfo', 'multichoice'));
        if (count($request->extrainfo)) {
            $roster->extrainfo=implode(",", $request->extrainfo);
        } else {
            $roster->extrainfo="";
        }
        if (count($request->multichoice)) {
            $roster->multichoice=implode(",", $request->multichoice);
        } else {
            $roster->multichoice="";
        }
        $roster->save();
        if ($request->groups=="") {
            $roster->group()->detach();
        } else {
            $newgroups = array_map('intval', $request->groups);
            $roster->group()->sync($newgroups);
        }
        return Redirect::back()->with('okmessage', 'Data updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        print "Delete $id";
    }

    public function design($id)
    {
        print "Delete $id";
    }

    public function sms($id, $send, Request $request)
    {
        $settings=$this->settings->makearray();
        $extra=array();
        $extra=$request->extrainfo;
        $data['extrainfo']=$extra;
        $daysofweek=array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
        $data['roster'] = Roster::with(array('group'))->find($id);
        $data['rosterday']=$daysofweek[$data['roster']->dayofweek-1];
        $dday=date("Y-m-d", strtotime('next ' . $data['rosterday']));
        $rosterdetails=DB::table('group_individual_roster')->join('groups', 'group_id', '=', 'groups.id')->join('individuals', 'individual_id', '=', 'individuals.id')->join('rosters', 'roster_id', '=', 'rosters.id')->select('surname', 'firstname', 'cellphone', 'groupname', 'message', 'dayofweek', 'group_id', 'household_id')->where('rosterdate', '=', $dday)->where('roster_id', '=', $id)->orderby('groupname')->get();
        foreach ($rosterdetails as $detail) {
            $dum['cellphone']=$detail->cellphone;
            $dum['message']=$detail->message . " (" . $detail->groupname . ")";
            $dum['household']=$detail->household_id;
            if (($extra) and (array_key_exists($detail->group_id, $extra))) {
                $dum['message']=$dum['message'] . " (" . $extra[$detail->group_id] . ")";
            }
            if (strpos($dum['message'], "[dayofweek]")) {
                $dum['message']=str_replace("[dayofweek]", $data['rosterday'], $dum['message']);
            }
            if (strpos($dum['message'], "[groupname]")) {
                $dum['message']=str_replace("[groupname]", $detail->groupname, $dum['message']);
            }
            if (strpos($dum['message'], "[firstname]")) {
                $dum['message']=str_replace("[firstname]", $detail->firstname, $dum['message']);
            }
            $dum['recipient']=$detail->firstname . " " . $detail->surname;
            $data['rosterdetails'][]=$dum;
        }
        $data['rosterdate']=$dday;
        if ($settings['sms_provider']=="bulksms") {
            $data['credits']=SMSfunctions::BS_get_credits($settings['sms_username'], $settings['sms_password']);
        } else {
            $data['credits']=SMSfunctions::SF_checkCredits($settings['sms_username'], $settings['sms_password']);
        }
        if ($send=="preview") {
            return View::make('connexion::rosters.sms', $data);
        } else {
            if ($settings['sms_provider']=="bulksms") {
                if (count($data['rosterdetails'])>SMSfunctions::BS_get_credits($settings['sms_username'], $settings['sms_password'])) {
                    return Redirect::back()->withInput()->withErrors("Insufficient Bulk SMS credits to send SMS");
                }
                $url = 'http://community.bulksms.com/eapi/submission/send_sms/2/2.0';
                $port = 80;
            } elseif ($settings['sms_provider']=="smsfactory") {
                if (count($data['rosterdetails'])>SMSfunctions::SF_checkCredits($settings['sms_username'], $settings['sms_password'])) {
                    return Redirect::back()->withInput()->withErrors("Insufficient SMS Factory credits to send SMS");
                }
            }
            foreach ($data['rosterdetails'] as $sms) {
                $seven_bit_msg=$sms['message'] . " (From " . $settings['site_abbreviation'] . ")";
                if ($settings['sms_provider']=="bulksms") {
                    $transient_errors = array(40 => 1);
                    $msisdn = "+27" . substr($sms['cellphone'], 1);
                    $post_body = SMSfunctions::BS_seven_bit_sms($settings['sms_username'], $settings['sms_password'], $seven_bit_msg, $msisdn);
                }
                $dum2['name']=$sms['recipient'];
                $dum2['household']=$sms['household'];
                if (SMSfunctions::checkcell($sms['cellphone'])) {
                    if ($settings['sms_provider']=="bulksms") {
                        $smsresult = SMSfunctions::BS_send_message($post_body, $url, $port);
                    } elseif ($settings['sms_provider']=="smsfactory") {
                        $smsresult = SMSfunctions::SF_sendSms($settings['sms_username'], $settings['sms_password'], $sms['cellphone'], $seven_bit_msg);
                    }
                    $dum2['address']=$sms['cellphone'];
                } else {
                    if ($sms['cellphone']=="") {
                        $dum2['address']="No cell number provided.";
                    } else {
                        $dum2['address']="Invalid cell number: " . $sms['cellphone'] . ".";
                    }
                }
                $results[]=$dum2;
            }
            $data['results']=$results;
            $data['type']="SMS";
        }
        return View::make('connexion::rosters.results', $data);
    }

    public function revise()
    {
        $total = count($_POST['group_id']);
        $alldates=array_unique($_POST['rosterdate']);
        foreach ($alldates as $thisdate) {
            DB::table('group_individual_roster')->where('rosterdate', '=', $thisdate)->where('roster_id', '=', $_POST['roster_id'])->delete();
        }
        for ($i=0;$i<$total;$i++) {
            if ($_POST['individual_id'][$i]<>0) {
                DB::table('group_individual_roster')->insert(array('group_id' => $_POST['group_id'][$i],'individual_id' => $_POST['individual_id'][$i],'rosterdate'=>$_POST['rosterdate'][$i],'selection'=>$_POST['selectnum'][$i],'roster_id'=>$_POST['roster_id']));
            }
        }
        return Redirect::back()->with('okmessage', 'Data updated');
    }

    public function details($id, $year, $month)
    {
        $data['roster'] = Roster::with('group')->find($id);
        $extrainfo = explode(",", $data['roster']->extrainfo);
        $data['extragroups']=Group::whereIn('id', $extrainfo)->get();
        $data['multigroups'] = explode(",", $data['roster']->multichoice);
        $subcat=explode(",", $data['roster']->subcategories);
        if ($subcat[0]<>"") {
            $subcat[]="#!@";
            foreach ($data['roster']->group as $thisgroup) {
                $shortened=false;
                foreach ($subcat as $thisubcat) {
                    if (strpos($thisgroup->groupname, $thisubcat)) {
                        $key=trim(str_replace($thisubcat, "", $thisgroup->groupname));
                        $shortgroups[$key][$thisubcat]=$thisgroup->id;
                        $shortened=true;
                    }
                }
                if (!$shortened) {
                    $key=trim($thisgroup->groupname);
                    $shortgroups["_" . $key]['#!@']=$thisgroup->id;
                }
            }
        } else {
            foreach ($data['roster']->group as $thisgroup) {
                $shortgroups[$thisgroup->groupname]['#!@']=$thisgroup->id;
            }
            $subcat[0]="#!@";
        }
        ksort($shortgroups);
        $firstinmonth=$data['roster']->dayofweek-date_format(date_create($year . "-" . $month . '-01'), 'N')+1;
        if ($firstinmonth>7) {
            $firstinmonth=$firstinmonth-7;
        } elseif ($firstinmonth<1) {
            $firstinmonth=$firstinmonth+7;
        }
        $dates[]=date_format(date_create($year . "-" . $month . '-' . $firstinmonth), 'Y-m-d');
        for ($i=1;$i<5;$i++) {
            $testdate=strtotime('+1 week', strtotime($dates[$i-1]));
            if (date("m", $testdate)==$month) {
                $dates[]=date("Y-m-d", $testdate);
            } else {
                break;
            }
        }
        $selnum=array('1','2');
        foreach ($dates as $tdate) {
            foreach ($shortgroups as $skey=>$sgrp) {
                foreach ($subcat as $thiscat) {
                    foreach ($selnum as $seln) {
                        if (array_key_exists($thiscat, $sgrp)) {
                            $individ = DB::table('group_individual_roster')->where('rosterdate', '=', $tdate)->where('roster_id', '=', $id)->where('group_id', '=', $sgrp[$thiscat])->where('selection', '=', $seln)->get();
                            $data['weeks'][$tdate][$thiscat][$skey][$seln]['group_id']=$sgrp[$thiscat];
                            if (isset($individ[0]->individual_id)) {
                                $data['weeks'][$tdate][$thiscat][$skey][$seln]['individual_id']=$individ[0]->individual_id;
                            }
                        }
                    }
                }
            }
        }
        $data['groupheadings']=array_keys($shortgroups);
        $data['rosterdetails'] = Roster::with('rosterdetails_group', 'rosterdetails_individual')->find($id);
        foreach ($data['roster']->group as $grp) {
            $data['groupmembers'][$grp->id][0]="";
            foreach ($grp->individuals as $ind) {
                $data['groupmembers'][$grp->id][$ind->id]=$ind->firstname . " " . $ind->surname;
            }
        }
        $data['rosteryear']=$year;
        $data['rostermonth']=$month;
        $data['months']=array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
        return View::make('connexion::rosters.details', $data);
    }
}
