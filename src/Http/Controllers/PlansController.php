<?php

namespace Bishopm\Connexion\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException, Bishopm\Connexion\Models\Individual;
use Illuminate\Http\Request, Bishopm\Connexion\Models\Plan, Bishopm\Connexion\Models\Society, Bishopm\Connexion\Models\Meeting, Auth;
use Bishopm\Connexion\Models\Preacher, Bishopm\Connexion\Models\Service, Bishopm\Connexion\Libraries\Fpdf\Fpdf;
use Bishopm\Connexion\Http\Requests\PlansRequest, Helpers, Redirect, View, Bishopm\Connexion\Models\Weekday;
use App\Http\Controllers\Controller, Bishopm\Connexion\Repositories\SettingsRepository;

class PlansController extends Controller
{

    private $settings;

    public function __construct(SettingsRepository $settings)
    {
        $this->settings=$settings->makearray();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('connexion::plans.edit');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($yy,$qq,$aa)
    {
        $fin=array();
        $fm=2;
        $m1=$qq*3-3+$fm;
        $y1=$yy;
        $m2=$qq*3-2+$fm;
        $y2=$yy;
        $m3=$qq*3-1+$fm;
        $y3=$yy;
        if ($m2>12){
            $m2=$m2-12;
            $y2=$y2+1;
        }
        if ($m3>12){
            $m3=$m3-12;
            $y3=$y3+1;
        }
        $firstDateTime=mktime(0, 0, 0, $m1, 1, $y1);
        $firstDay=date("N", $firstDateTime);
        $firstSunday=date("d M Y",mktime(0, 0, 0, $m1, 8-$firstDay, $y1));
        $lastSunday=strtotime($firstSunday);
        $lastDay=mktime(23,59,59,$m3,cal_days_in_month(CAL_GREGORIAN, $m3, $y3),$y3);
        $extras=Weekday::where('servicedate','>=',$firstDateTime)->where('servicedate','<=',$lastDay)->orderBy('servicedate')->get()->toArray();
        $data['meetings']=Meeting::where('meetingdatetime','<',$lastDay)->where('meetingdatetime','>',$firstDateTime)->orderBy('meetingdatetime')->get();
        $dum['dt']=$lastSunday;
        $dum['yy']=intval(date("Y",$lastSunday));
        $dum['mm']=intval(date("n",$lastSunday));
        $dum['dd']=intval(date("j",$lastSunday));
        $sundays[]=$dum;
        $data['societies']=Society::orderBy('society')->with('services')->get();
        $data['preachers']=Preacher::where('status','=','Local preacher')->orWhere('status','=','On trial preacher')->get();
        $data['ministers']=Preacher::where('status','=','Minister')->get();
        $data['guests']=Preacher::where('status','=','Guest')->get();
        while (date($lastSunday+604800<=$lastDay)) {
          $lastSunday=$lastSunday+604800;
          $dum['dt']=$lastSunday;
          $dum['yy']=intval(date("Y",$lastSunday));
          $dum['mm']=intval(date("n",$lastSunday));
          $dum['dd']=intval(date("j",$lastSunday));
          $sundays[]=$dum;
        }
        if (count($extras)){
          $xco=0;
          for ($q = 0; $q < count($sundays); $q++){
            if (($xco<count($extras)) and ($extras[$xco]['servicedate']<$sundays[$q]['dt'])){
              $dum['dt']=$extras[$xco]['servicedate'];
              $dum['yy']=intval(date("Y",$extras[$xco]['servicedate']));
              $dum['mm']=intval(date("n",$extras[$xco]['servicedate']));
              $dum['dd']=intval(date("j",$extras[$xco]['servicedate']));
              $data['sundays'][]=$dum;
              $xco++;
              $q=$q-1;
            } else {
              $data['sundays'][]=$sundays[$q];
            }
          }
        } else {
          $data['sundays']=$sundays;
        }
        $pm1=Plan::where('planyear','=',$y1)->where('planmonth','=',$m1)->get();
        foreach ($pm1 as $p1){
            $soc=Society::find($p1->society_id)->society;
            $ser=Service::find($p1->service_id)->servicetime;
            if ($p1->preacher->status=="Minister"){
              $p1typ="M_";
            } elseif ($p1->preacher->status=="Guest"){
              $p1typ="G_";
            } else {
              $p1typ="P_";
            }
            if ($p1->preacher_id){
              @$data['fin'][$soc][$p1->planyear][$p1->planmonth][$p1->planday][$ser]['preacher']=$p1typ . $p1->preacher->id;
              @$data['fin'][$soc][$p1->planyear][$p1->planmonth][$p1->planday][$ser]['pname']=substr($p1->preacher->firstname,0,1) . " " . $p1->preacher->surname;
            } else {
              @$data['fin'][$soc][$p1->planyear][$p1->planmonth][$p1->planday][$ser]['preacher']="";
            }
            if ($p1->servicetype){
              @$data['fin'][$soc][$p1->planyear][$p1->planmonth][$p1->planday][$ser]['tname']=$p1->servicetype;
            } else {
              @$data['fin'][$soc][$p1->planyear][$p1->planmonth][$p1->planday][$ser]['tag']="";
            }
        }

        $pm2=Plan::where('planyear','=',$y2)->where('planmonth','=',$m2)->get();
        foreach ($pm2 as $p2){
            $soc=Society::find($p2->society_id)->society;
            $ser=Service::find($p2->service_id)->servicetime;
            if ($p2->preacher->status=="Minister"){
              $p2typ="M_";
            } elseif ($p2->preacher->status=="Guest"){
              $p2typ="G_";
            } else {
              $p2typ="P_";
            }
            if ($p2->preacher_id){
              @$data['fin'][$soc][$p2->planyear][$p2->planmonth][$p2->planday][$ser]['preacher']=$p2typ . $p2->preacher->id;
              @$data['fin'][$soc][$p2->planyear][$p2->planmonth][$p2->planday][$ser]['pname']=substr($p2->preacher->firstname,0,1) . " " . $p2->preacher->surname;
            } else {
              @$data['fin'][$soc][$p2->planyear][$p2->planmonth][$p2->planday][$ser]['preacher']="";
            }
            if ($p2->servicetype){
              @$data['fin'][$soc][$p2->planyear][$p2->planmonth][$p2->planday][$ser]['tname']=$p2->servicetype;
            } else {
              @$data['fin'][$soc][$p2->planyear][$p2->planmonth][$p2->planday][$ser]['tag']="";
            }
        }

        $pm3=Plan::where('planyear','=',$y3)->where('planmonth','=',$m3)->get();
        foreach ($pm3 as $p3){
            $soc=Society::find($p3->society_id)->society;
            $ser=Service::find($p3->service_id)->servicetime;
            if ($p3->preacher->status=="Minister"){
              $p3typ="M_";
            } elseif ($p3->preacher->status=="Guest"){
              $p3typ="G_";
            } else {
              $p3typ="P_";
            }
            if ($p3->preacher_id){
              @$data['fin'][$soc][$p3->planyear][$p3->planmonth][$p3->planday][$ser]['preacher']=$p3typ . $p3->preacher->id;
              @$data['fin'][$soc][$p3->planyear][$p3->planmonth][$p3->planday][$ser]['pname']=substr($p3->preacher->firstname,0,1) . " " . $p3->preacher->surname;
            } else {
              @$data['fin'][$soc][$p3->planyear][$p3->planmonth][$p3->planday][$ser]['preacher']="";
            }
            if ($p3->servicetype){
              @$data['fin'][$soc][$p3->planyear][$p3->planmonth][$p3->planday][$ser]['tname']=$p3->servicetype;
            } else {
              @$data['fin'][$soc][$p3->planyear][$p3->planmonth][$p3->planday][$ser]['tag']="";
            }
        }
        
        $data['tags']=array('COM','COV');
        if ($qq==1){
          $data['prev']="plan/" . strval($yy-1) . "/4";
        } else {
          $data['prev']="plan/$yy/" . strval($qq-1);
        }
        if ($qq==4){
          $data['next']="plan/" . strval($yy+1) . "/1";
        } else {
          $data['next']="plan/$yy/" . strval($qq+1);
        }
        if ($aa=="edit"){
          return View::make('connexion::plans.edit',$data);
        } else {
          $data['pb']=$this->settings['presiding_bishop'];
          if (!$data['pb']){
            return view('errors.errors')->with('errormessage','Before you can view the plan, please enter the name of the Presiding Bishop');
          }
          $data['gs']=$this->settings['general_secretary'];
          if (!$data['gs']){
            return view('errors.errors')->with('errormessage','Before you can view the plan, please enter the name of the General Secretary');
          }
          $data['db']=$this->settings['district_bishop'];
          if (!$data['db']){
            return view('errors.errors')->with('errormessage','Before you can view the plan, please enter the name of the District Bishop');
          }
          $data['super']=$this->settings['superintendent'];
          if (!$data['super']){
            return view('errors.errors')->with('errormessage','Before you can view the plan, please specify who the Circuit Superintendent is');
          }
          $this->report($data);
        }
    }

    public function report($dat){
      $pdf = new Fpdf();
      $pdf->AddPage('L');
      $logopath=base_path() . '/public/vendor/bishopm/images/mcsa.jpg';
      $pdf->SetAutoPageBreak(true,0);
      $pdf->SetFont('Arial','',9);
      $num_ser=0;
      foreach ($dat['societies'] as $s1){
        foreach ($s1->services as $se1){
          $num_ser++;
        }
      }
      $header=20;
      $left_side=5;
      $left_edge=40;
      $num_soc=count($dat['societies']);
      $num_sun=count($dat['sundays']);
      $soc_width=$left_edge-17;
      $pg_height=210;
      $pg_width=297;
      $y=$header;
      $x=$left_edge;
      $y_add=($pg_height-$header-3*($num_ser-$num_soc))/$num_ser;
      if ($y_add>16){
        $y_add=16;
      }
      $x_add=($pg_width-5-$left_edge)/$num_sun;
      $toprow=true;
      $pdf->Image($logopath,5,5,0,21);
      $pdf->SetFillColor(0,0,0);
      $pdf->SetFont('Arial','B',14);
      $pdf->text($left_side+$soc_width,10,"THE METHODIST CHURCH OF SOUTHERN AFRICA: " . strtoupper($this->settings['circuit_name']) . " CIRCUIT " . $this->settings['circuit_number']);
      $pdf->text($left_side+$soc_width,17,"PREACHING PLAN: " . strtoupper(date("F Y",$dat['sundays'][0]['dt'])) . " - " . strtoupper(date("F Y",$dat['sundays'][count($dat['sundays'])-1]['dt'])));
	    foreach ($dat['societies'] as $soc){
        $firstserv=true;
        foreach ($soc->services as $ser){
          if ($firstserv){
            $y=$y+$y_add;
            $pdf->SetFont('Arial','B',8);
            $pdf->rect($left_side,$y-2,($pg_width-2*$left_side),$y_add+($y_add)*(count($soc->services)-1)-(3*(count($soc->services)-1)),'D');
            $pdf->setxy($left_side,$y);
            if (count($soc->services)==1){
              $pdf->setxy($left_side,$y);
            } else {
              $pdf->setxy($left_side,$y+(($y_add-3)*(count($soc->services)-1)/2));
            }
            $font_size = 8;
            $decrement_step = 0.1;
            $pdf->SetFont('Arial','B',$font_size);
            while($pdf->GetStringWidth($soc->society) > $soc_width-2) {
              $pdf->SetFontSize($font_size -= $decrement_step);
            }
            $pdf->cell($soc_width,$y_add-3,$soc->society,0,0,'R');
            $pdf->SetFont('Arial','B',8);
            $pdf->setxy($left_side+$soc_width,$y);
            $pdf->cell(12,$y_add-3,$ser->servicetime,0,0,'C');
            $pdf->SetFillColor(0,0,0);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
          } else {
            $y=$y+$y_add-3;
            $pdf->SetFont('Arial','B',8);
            $pdf->setxy($left_side+$soc_width,$y);
            $pdf->cell(12,$y_add-3,$ser->servicetime,0,0,'C');
            $pdf->SetFillColor(0,0,0);
            $pdf->SetTextColor(0,0,0);
          }
          $firstserv=false;
          foreach ($dat['sundays'] as $sun){
            if ($toprow){
              // Weekly dates
              $pdf->SetFont('Arial','B',8);
              if (date("D",$sun['dt'])=="Sun"){
                $pdf->setxy($x,$header+2);
                $pdf->cell($x_add,$y_add-6,date("j M",$sun['dt']),0,0,'C');
              } else {
                $wd=Weekday::where('servicedate','=',$sun['dt'])->first();
                $pdf->setxy($x,$header+4);
                $pdf->SetFont('Arial','',7);
                $pdf->cell($x_add,$y_add-6,$wd->description,0,0,'C');
                $pdf->SetFont('Arial','B',8);
                $pdf->setxy($x,$header);
                $pdf->cell($x_add,$y_add-6,date("j M",$sun['dt']),0,0,'C');
              }
            }
            if (isset($dat['fin'][$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['tname'])){
              $tagadd=1;
              $pdf->setxy($x,$y-2);
              $pdf->SetFont('Arial','B',7.5);
              $pdf->cell($x_add,$y_add-2,$dat['fin'][$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['tname'],0,0,'C');
            } else {
              $tagadd=0;
            }
            if (isset($dat['fin'][$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['pname'])){
              $pdf->setxy($x,$y+$tagadd);
              $pname=utf8_decode($dat['fin'][$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser->servicetime]['pname']);
              $font_size = 8;
              $decrement_step = 0.1;
              $pdf->SetFont('Arial','',$font_size);
              while($pdf->GetStringWidth($pname) > $x_add-1) {
            	$pdf->SetFontSize($font_size -= $decrement_step);
              }
              $pdf->cell($x_add,$y_add-3,$pname,0,0,'C');
            }
            $x=$x+$x_add;
          }
          $toprow=false;
          $x=$left_edge;
        }
      }
      $x2=$x;
      foreach ($dat['sundays'] as $sun2){
          $pdf->line($x2,$header+$y_add-2,$x2,$y+$y_add-2);
          $x2=$x2+$x_add;
      }
      $pdf->AddPage('L');
      $pdf->Image($logopath,10,5,0,21);
      $pdf->SetFillColor(0,0,0);
      $pdf->SetFont('Arial','B',14);
      $pdf->text($left_side+$soc_width+8,10,"THE METHODIST CHURCH OF SOUTHERN AFRICA: " . $this->settings['circuit_name'] . " CIRCUIT " . $this->settings['circuit_number']);
      $pdf->text($left_side+$soc_width+8,17,"PREACHING PLAN: " . strtoupper(date("F Y",$dat['sundays'][0]['dt'])) . " - " . strtoupper(date("F Y",$dat['sundays'][count($dat['sundays'])-1]['dt'])));
      $pfin=array();
      foreach($dat['preachers'] as $preacher1){
        $dum=array();
        $thissoc=Society::find($preacher1->society_id)->society;
        $dum['name']=$preacher1->title . " " . $preacher1->firstname . " " . $preacher1->surname;
        if ($preacher1->emeritus){
          $dum['name'] = $dum['name'] . "*";
        }
        $dum['soc']=$preacher1->society_id;
        $dum['cellphone']=$preacher1->phone;
        $dum['fullplan']=$preacher1->fullplan;
        $dum['status']=$preacher1->status;
        if ($dum['fullplan']=="Trial"){
            $vdum['9999' . $preacher1->surname . $preacher1->firstname]=$dum;
        } else {
            $vdum[$preacher1->fullplan . $preacher1->surname . $preacher1->firstname]=$dum;
        }
      }
      ksort($vdum);
      foreach ($vdum as $vd){
        $thissoc=Society::find($vd['soc'])->society;
      	$pfin[$thissoc][]=$vd;
      }
      $cols=4;
      $spacer=5;
      $col_width=($pg_width-(2*$left_side))/$cols;
      $y=30;
      $col=1;
      $pdf->SetFont('Arial','',8);
      $pdf->text($left_side+$spacer,$y,"Presiding Bishop: " . $dat['pb']);
      $y=$y+4;
      $pdf->text($left_side+$spacer,$y,"General Secretary: " . $dat['gs']);
      $y=$y+4;
      $pdf->text($left_side+$spacer,$y,"District Bishop: " . $dat['db']);
      $y=$y+4;
      $pdf->text($left_side+$spacer,$y,"Superintendent: " . $dat['super']);
      $y=$y+6;
      $pdf->SetFont('Arial','B',11);
      $pdf->text($left_side+$spacer,$y,"Circuit Ministers");
      $y=$y+4;
      $pdf->SetFont('Arial','',8);
      foreach ($dat['ministers'] as $min){
          $pdf->text($left_side+$spacer,$y,$min->title . " " . substr($min->firstname,0,1) . " " . $min->surname . " (" . $min->phone . ")");
          $y=$y+4;
      }
      $y=$y+2;
      /*
      $pdf->SetFont('Arial','',8);
      $officers=explode(',',Helpers::getSetting('circuit_stewards'));
      $subhead="";
      $pdf->SetFont('Arial','B',11);
      $pdf->text($left_side+$spacer,$y,"Circuit Stewards");
      $pdf->SetFont('Arial','',8);
      foreach ($officers as $officer){
        $y=$y+4;
        $fn=Individual::find($officer);
        $pdf->text($left_side+$spacer,$y,$fn->title . " " . $fn->firstname . " " . $fn->surname . " (" . $fn->cellphone . ")");
      }
      $pdf->SetFont('Arial','B',11);
      $y=$y+6;
      $pdf->text($left_side+$spacer,$y,"Circuit Treasurer");
      $pdf->SetFont('Arial','',8);
      $treasurer=Helpers::getSetting('treasurer');
      $y=$y+4;
      $fn=Individual::find($treasurer);
      $pdf->text($left_side+$spacer,$y,$fn->title . " " . $fn->firstname . " " . $fn->surname . " (" . $fn->cellphone . ")");
      $pdf->SetFont('Arial','B',11);
      $y=$y+6;
      $pdf->SetFont('Arial','B',11);
      $pdf->text($left_side+$spacer,$y,"Circuit Office");
      $circuitoffice=Society::find(Helpers::getSetting('circuit_office'));
      $pdf->SetFont('Arial','',8);
      $y=$y+4;
      $pdf->text($left_side+$spacer,$y,$circuitoffice->society . " Methodist Church");
      if ($circuitoffice->phone){
          $y=$y+4;
          $pdf->text($left_side+$spacer,$y,"Phone: " . $circuitoffice->phone);
      }
      if ($circuitoffice->email){
          $y=$y+4;
          $pdf->text($left_side+$spacer,$y,"Email: " . $circuitoffice->email);
      }
      $csecretary=Helpers::getSetting('circuit_secretary');
      if ($csecretary){
          $y=$y+4;
          $pdf->SetFont('Arial','',8);
          $fn=Individual::find($csecretary);
          $pdf->text($left_side+$spacer,$y,"Secretary: " . $fn->title . " " . $fn->firstname . " " . $fn->surname);
      }
      $y=$y+6;
      */
      if (count($dat['meetings'])){
        $pdf->SetFont('Arial','B',11);
        $pdf->text($left_side+$spacer,$y,"Circuit Meetings");
        $y=$y+4;
        foreach ($dat['meetings'] as $meeting){
          $x=$left_side+$spacer+($col-1)*$col_width;
          $pdf->SetFont('Arial','B',8);
          $pdf->text($x,$y,$meeting['description']);
          $pdf->SetFont('Arial','',8);
          $y=$y+4;
          $msoc=Society::find($meeting['society_id'])->society;
          $pdf->text($x,$y,date("d M Y H:i",$meeting['meetingdatetime']) . " (" . $msoc . ")");
          $y=$y+4;
        }
      }
      $y=$y+2;

      $col++;
      $x=$left_side+$spacer+($col-1)*$col_width;
      $y=30;
      $pdf->SetFont('Arial','B',11);
      $pdf->text($x,$y,"Local Preachers");
/*      $supervisor=Helpers::getSetting('supervisor_of_studies');
      if ($supervisor){
          $y=$y+4;
          $pdf->SetFont('Arial','',8);
          $fn=Individual::find($supervisor);
          $pdf->text($x,$y,"Supervisor of studies: " . $fn->title . " " . $fn->firstname . " " . $fn->surname);
      }
      $lpsec=Helpers::getSetting('local_preachers_secretary');
      if ($lpsec){
          $y=$y+4;
          $pdf->SetFont('Arial','',8);
          $fn=Individual::find($lpsec);
          $pdf->text($x,$y,"Local Preachers Secretary: " . $fn->title . " " . $fn->firstname . " " . $fn->surname);
      }*/
      $y=$y+4;
      $ythresh=200;
      ksort($pfin);
      foreach ($pfin as $key=>$soc){
        if ($y>$ythresh-6){
          $col++;
          $y=30;
        }
        $x=$left_side+$spacer+($col-1)*$col_width;
        $pdf->SetFont('Arial','B',9);
        $y=$y+2;
        $pdf->text($x,$y,$key);
        $y=$y+4;
        $pdf->SetFont('Arial','',8);

        foreach ($soc as $pre){
          if ($y>$ythresh){
            $col++;
            $x=$left_side+$spacer+($col-1)*$col_width;
            $y=30;
          }
          $pre['name']=utf8_decode($pre['name']);
          if (($pre['status']=="Local preacher") or ($pre['status']=="On trial preacher")){
            $pdf->text($x+2,$y,$pre['fullplan']);
            $pdf->text($x+10,$y,$pre['name'] . " (" . $pre['cellphone'] . ")");
            $y=$y+4;
          }
        }
      }
      $pdf->SetFont('Arial','',8);
      $y=$y+4;
      $pdf->text($x+2,$y,"* Emeritus");
  	  $pdf->Output();
      exit;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlansRequest $request, $id)
    {
      foreach ($request->all() as $key=>$val){
        if (substr($key,0,2)=="p_"){
          $tagname="t_" . substr($key,2);
          $tag=$request->input($tagname);
          if (!$tag){
            $tag=null;
          }
          if ($val){
            $pid=substr($val,2);
          } else {
            $pid=null;
          }
          $kk=array(explode('_',$key));
          $plan=Plan::where('society_id','=',$kk[0][1])->where('service_id','=',$kk[0][2])->where('planyear','=',$kk[0][3])->where('planmonth','=',$kk[0][4])->where('planday','=',$kk[0][5])->first();
          if (count($plan)){
            $plan->servicetype=$tag;
            $plan->preacher_id=$pid;
            if (($tag==null) and ($pid==null)){
              $plan->delete();
            } else {
              $plan->save();
            }
          } else {
            if (($tag) or ($pid)){
              $newplan=Plan::create(array('society_id'=>$kk[0][1], 'service_id'=>$kk[0][2], 'planyear'=>$kk[0][3], 'planmonth'=>$kk[0][4], 'planday'=>$kk[0][5], 'preacher_id'=>$pid, 'servicetype'=>$tag));
            }
          }
        }
      }
      return Redirect::back()->withSuccess('Plan details have been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
