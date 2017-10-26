<?php
namespace Bishopm\Connexion\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException, Bishopm\Connexion\Models\Individual;
use Illuminate\Http\Request, Auth;
use Bishopm\Connexion\Libraries\Fpdf\Fpdf;
use Bishopm\Connexion\Http\Requests\PlansRequest;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Repositories\SettingsRepository, Bishopm\Connexion\Repositories\WeekdaysRepository;
use Bishopm\Connexion\Repositories\MeetingsRepository, Bishopm\Connexion\Repositories\SocietiesRepository;
use Bishopm\Connexion\Repositories\PreachersRepository, Bishopm\Connexion\Repositories\PlansRepository;
use Bishopm\Connexion\Repositories\ServicesRepository;

class PlansController extends Controller
{

    private $settings, $weekdays, $meetings, $societies, $preachers, $plans, $services;

    public function __construct(SettingsRepository $settings, WeekdaysRepository $weekdays, MeetingsRepository $meetings, SocietiesRepository $societies,
        PreachersRepository $preachers, PlansRepository $plans, ServicesRepository $services)
    {
        $this->settings=$settings->makearray();
        $this->weekdays=$weekdays;
        $this->meetings=$meetings;
        $this->societies=$societies;
        $this->preachers=$preachers;
        $this->plans=$plans;
        $this->services=$services;
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

    public function currentplan($status="view")
    {
      $one=range(2,4);
      $two=range(5,7);
      $three=range(8,10);
      $four=range(11,12);
      $m=intval(date('n'));
      $y=intval(date('Y'));
      if (in_array($m,$one)){
        $this->show($y,1,$status);
      } elseif (in_array($m,$two)){
        $this->show($y,2,$status);
      } elseif (in_array($m,$three)){
        $this->show($y,3,$status);
      } elseif (in_array($m,$four)){
        $this->show($y,4,$status);
      } elseif ($m==1){
        $this->show($y-1,4,$status);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($yy,$qq,$aa)
    {
      $data=$this->plans->show($yy,$qq);
      if ($data=="Invalid"){
        return redirect()->route('admin.settings.index')->with('notice','Please ensure that the API url and token are correctly specified');
      } 
      if ($aa=="edit"){
        return view('connexion::plans.edit',$data);
      } else {
        $data['pb']=$this->settings['presiding_bishop'];
        if (!$data['pb']){
          return view('connexion::shared.errors')->with('errormessage','Before you can view the plan, please enter the name of the Presiding Bishop');
        }
        $data['gs']=$this->settings['general_secretary'];
        if (!$data['gs']){
          return view('connexion::shared.errors')->with('errormessage','Before you can view the plan, please enter the name of the General Secretary');
        }
        $data['db']=$this->settings['district_bishop'];
        if (!$data['db']){
          return view('connexion::shared.errors')->with('errormessage','Before you can view the plan, please enter the name of the District Bishop');
        }
        $data['super']=$this->settings['superintendent'];
        if (!$data['super']){
          return view('connexion::shared.errors')->with('errormessage','Before you can view the plan, please specify who the Circuit Superintendent is');
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
        foreach ($s1['services'] as $se1){
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
      $pdf->text($left_side+$soc_width,10,"THE METHODIST CHURCH OF SOUTHERN AFRICA: " . strtoupper($dat['circuit']['circuit']) . " " . $dat['circuit']['circuitnumber']);
      $pdf->text($left_side+$soc_width,17,"PREACHING PLAN: " . strtoupper(date("F Y",$dat['sundays'][0]['dt'])) . " - " . strtoupper(date("F Y",$dat['sundays'][count($dat['sundays'])-1]['dt'])));
	    foreach ($dat['societies'] as $soc){
        $firstserv=true;
        foreach ($soc['services'] as $ser){
          if ($firstserv){
            $y=$y+$y_add;
            $pdf->SetFont('Arial','B',8);
            $pdf->rect($left_side,$y-2,($pg_width-2*$left_side),$y_add+($y_add)*(count($soc['services'])-1)-(3*(count($soc['services'])-1)),'D');
            $pdf->setxy($left_side,$y);
            if (count($soc['services'])==1){
              $pdf->setxy($left_side,$y);
            } else {
              $pdf->setxy($left_side,$y+(($y_add-3)*(count($soc['services'])-1)/2));
            }
            $font_size = 8;
            $decrement_step = 0.1;
            $pdf->SetFont('Arial','B',$font_size);
            while($pdf->GetStringWidth($soc['society']) > $soc_width-2) {
              $pdf->SetFontSize($font_size -= $decrement_step);
            }
            $pdf->cell($soc_width,$y_add-3,$soc['society'],0,0,'R');
            $pdf->SetFont('Arial','B',8);
            $pdf->setxy($left_side+$soc_width,$y);
            $pdf->cell(12,$y_add-3,$ser['servicetime'],0,0,'C');
            $pdf->SetFillColor(0,0,0);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
          } else {
            $y=$y+$y_add-3;
            $pdf->SetFont('Arial','B',8);
            $pdf->setxy($left_side+$soc_width,$y);
            $pdf->cell(12,$y_add-3,$ser['servicetime'],0,0,'C');
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
                $wd=$this->weekdays->findfordate($dat['circuit']['id'],$sun['dt']);
                $pdf->setxy($x,$header+4);
                $pdf->SetFont('Arial','',7);
                $pdf->cell($x_add,$y_add-6,$wd->description,0,0,'C');
                $pdf->SetFont('Arial','B',8);
                $pdf->setxy($x,$header);
                $pdf->cell($x_add,$y_add-6,date("j M",$sun['dt']),0,0,'C');
              }
            }
            if (isset($dat['fin'][$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['tname'])){
              $tagadd=1;
              $pdf->setxy($x,$y-2);
              $pdf->SetFont('Arial','B',7.5);
              $pdf->cell($x_add,$y_add-2,$dat['fin'][$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['tname'],0,0,'C');
            } else {
              $tagadd=0;
            }
            if (isset($dat['fin'][$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['pname'])){
              $pdf->setxy($x,$y+$tagadd);
              $pname=utf8_decode($dat['fin'][$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['pname']);
              $font_size = 8;
              $decrement_step = 0.1;
              $pdf->SetFont('Arial','',$font_size);
              while($pdf->GetStringWidth($pname) > $x_add-1) {
            	$pdf->SetFontSize($font_size -= $decrement_step);
              }
              $pdf->cell($x_add,$y_add-3,$pname,0,0,'C');
            }
            if (isset($dat['fin'][$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['trial'])){
              $pdf->setxy($x,$y+$tagadd+2.5);
              $trial=$this->preachers->find($dat['fin'][$soc['society']][$sun['yy']][$sun['mm']][$sun['dd']][$ser['servicetime']]['trial']);
              $tname="[" . utf8_decode(substr($trial->firstname,0,1) . " " . $trial->surname) . "]";
              $pdf->SetFont('Arial','',6.5);
              $pdf->cell($x_add,$y_add-3,$tname,0,0,'C');
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
      $pdf->text($left_side+$soc_width+8,10,"THE METHODIST CHURCH OF SOUTHERN AFRICA: " . strtoupper($dat['circuit']['circuit']) . " " . $dat['circuit']['circuitnumber']);
      $pdf->text($left_side+$soc_width+8,17,"PREACHING PLAN: " . strtoupper(date("F Y",$dat['sundays'][0]['dt'])) . " - " . strtoupper(date("F Y",$dat['sundays'][count($dat['sundays'])-1]['dt'])));
      $pfin=array();
      foreach($dat['preachers'] as $preacher1){
        $dum=array();
        $thissoc=$this->societies->find($preacher1['society_id'])->society;
        $dum['name']=$preacher1['title'] . " " . $preacher1['firstname'] . " " . $preacher1['surname'];
        if ($preacher1['status']=="Emeritus preacher"){
          $dum['name'] = $dum['name'] . "*";
        }
        $dum['soc']=$preacher1['society_id'];
        $dum['cellphone']=$preacher1['phone'];
        $dum['fullplan']=$preacher1['fullplan'];
        $dum['status']=$preacher1['status'];
        if ($dum['fullplan']=="Trial"){
            $vdum['9999' . $preacher1['surname'] . $preacher1['firstname']]=$dum;
        } else {
            $vdum[$preacher1['fullplan'] . $preacher1['surname'] . $preacher1['firstname']]=$dum;
        }
      }
      ksort($vdum);
      foreach ($vdum as $vd){
        $thissoc=$this->societies->find($vd['soc'])->society;
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
          $pdf->text($left_side+$spacer,$y,$min['title'] . " " . substr($min['firstname'],0,1) . " " . $min['surname'] . " (" . $min['phone'] . ")");
          $y=$y+4;
      }
      $y=$y+2;
      $pdf->SetFont('Arial','',8);
      $officers=$this->settings['circuit_stewards'];
      $subhead="";
      if ($officers){
        $pdf->SetFont('Arial','B',11);
        $pdf->text($left_side+$spacer,$y,"Circuit Stewards");
        $pdf->SetFont('Arial','',8);
        foreach (explode(',',$officers) as $officer){
          $y=$y+4;
          $pdf->text($left_side+$spacer,$y,$officer);
        }
      }
      $pdf->SetFont('Arial','B',11);
      $y=$y+6;
      $treasurer=$this->settings['circuit_treasurer'];
      if ($treasurer){
        $pdf->text($left_side+$spacer,$y,"Circuit Treasurer");
        $pdf->SetFont('Arial','',8);  
        $y=$y+4;
        $pdf->text($left_side+$spacer,$y,$treasurer);
        $pdf->SetFont('Arial','B',11);
        $y=$y+6;
      }
      $csecretary=$this->settings['circuit_secretary'];
      if ($treasurer){
        $pdf->text($left_side+$spacer,$y,"Circuit Secretary");
        $pdf->SetFont('Arial','',8);  
        $y=$y+4;
        $pdf->text($left_side+$spacer,$y,$csecretary);
        $pdf->SetFont('Arial','B',11);
        $y=$y+6;
      }
      $y=$y+6;
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
          $msoc=$this->societies->find($meeting['society_id'])->society;
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
      $supervisor=$this->settings['supervisor_of_studies'];
      if ($supervisor){
          $y=$y+4;
          $pdf->SetFont('Arial','',8);
          $pdf->text($x,$y,"Supervisor of studies: " . $supervisor);
      }
      $lpsec=$this->settings['local_preachers_secretary'];
      if ($lpsec){
          $y=$y+4;
          $pdf->SetFont('Arial','',8);
          $fn=Individual::find($lpsec);
          $pdf->text($x,$y,"Local Preachers Secretary: " . $lpsec);
      }
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
          if (($pre['status']=="Local preacher") or ($pre['status']=="On trial preacher") or ($pre['status']=="Emeritus preacher")){
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
    public function update($circuit,$box,$val)
    {
      $this->plans->updateplan($circuit,$box,$val);
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
