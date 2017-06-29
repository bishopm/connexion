<?php

namespace Bishopm\Connexion\Console;

use Illuminate\Console\Command;
use Bishopm\Connexion\Models\Book, Bishopm\Connexion\Models\Payment, Bishopm\Connexion\Models\Individual;
use Bishopm\Connexion\Models\Setting, DB;
use Bishopm\Connexion\Mail\GivingMail;
use Illuminate\Support\Facades\Mail;

class PlannedGivingReportEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'connexion:givingemails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send giving report by email to planned givers';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today="2017-07-10";
        $lagtime=intval(Setting::where('setting_key','giving_lagtime')->first()->setting_value);
        echo "You have a lag setting of " . $lagtime . " days\n";
        $effdate=strtotime($today)-$lagtime*86400;
        $repyr=date('Y',$effdate);
        echo "Your report year is " . $repyr . "\n";
        $reportnums=intval(Setting::where('setting_key','giving_reports')->first()->setting_value);
        echo "Your system will deliver " . $reportnums . " reports per year\n";
        switch ($reportnums){
            case 1:
                $reportdates=array($repyr . "-12-31");
                break;
            case 2:
                $reportdates=array($repyr . "-06-30",$repyr . "-12-31");
                break;
            case 3:
                $reportdates=array($repyr . "-04-30",$repyr . "-08-31",$repyr . "-12-31");
                break;
            case 4:
                $reportdates=array($repyr . "-03-31",$repyr . "-06-30",$repyr . "-09-30",$repyr . "-12-31");
                break;
            case 6:
                $reportdates=array($repyr . "-02-28",$repyr . "-04-30",$repyr . "-06-30",$repyr . "-08-31",$repyr . "-10-31",$repyr . "-12-31");
                break;
            case 12:
                $reportdates=array($repyr . "-01-31",$repyr . "-02-28",$repyr . "-03-31",$repyr . "-04-30",$repyr . "-05-31",$repyr . "-06-30",$repyr . "-07-31",$repyr . "-08-31",$repyr . "-09-30",$repyr . "-10-31",$repyr . "-11-30",$repyr . "-12-31");
                break;
        }
        if (in_array(date("Y-m-d",$effdate),$reportdates)){
            $period=12/$reportnums;
            $endofperiod=date('Y-m-t',$effdate);
            $startmonth=intval(date('m',$effdate))-$period+1;
            if ($startmonth<1){
                $startmonth=$startmonth+12;
            }
            if ($startmonth<10){
                $sm="0" . strval($startmonth);
            } else {
                $sm=strval($startmnonth);
            }
            $startofperiod=$repyr . "-" . $sm . "-01";
            echo "Calculating totals for the period: " . $startofperiod . " to " . $endofperiod . "\n";
            $givers=Individual::where('giving','>',1)->where('surname','Bishop')->get();
            $data=array();
            foreach ($givers as $giver){
                $data[$giver->giving]['email'][]=$giver->email;
                if (count($data[$giver->giving]['email'])==1){
                    $data[$giver->giving]['period']=$startofperiod . " to " . $endofperiod;
                    $data[$giver->giving]['sender']=Setting::where('setting_key','church_email')->first()->setting_value;
                    $data[$giver->giving]['pg']=$giver->giving;
                    $data[$giver->giving]['pgyr']=$repyr;                    
                    $data[$giver->giving]['church']=Setting::where('setting_key','site_abbreviation')->first()->setting_value;
                    if ($period==1){
                        $data[$giver->giving]['scope']="month";
                    } else {
                        $data[$giver->giving]['scope']=$period . " months";
                    }
                    $data[$giver->giving]['subject']="Planned giving feedback: " . $startofperiod . " to " . $endofperiod;
                    $currentpayments=Payment::where('pgnumber',$giver->giving)->where('paymentdate','>=',$startofperiod)->where('paymentdate','<=',$endofperiod)->orderBy('paymentdate','DESC')->get();
                    foreach ($currentpayments as $cp){
                        $data[$giver->giving]['current'][]=$cp;
                    }
                    $historicpayments=Payment::where('pgnumber',$giver->giving)->where('paymentdate','<',$startofperiod)->where('paymentdate','>=',$repyr . '-01-01')->orderBy('paymentdate','DESC')->get();
                    foreach ($historicpayments as $hp){
                        $data[$giver->giving]['historic'][]=$hp;
                    }
                }
            }
            foreach ($data as $key=>$pg){
                foreach ($pg['email'] as $indiv){
                    Mail::to($indiv)->send(new GivingMail($pg));
                }
            }
        } else {
            echo "Today is not a report date (" . date("Y-m-d",$effdate) . ")\n";
        }
    }
}
