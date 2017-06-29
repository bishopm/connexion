<?php

namespace Bishopm\Connexion\Console;

use Illuminate\Console\Command;
use Bishopm\Connexion\Models\Book, Bishopm\Connexion\Models\Transaction, Bishopm\Connexion\Models\Supplier, Bishopm\Connexion\Models\Group;
use Bishopm\Connexion\Models\Setting, DB;
use Bishopm\Connexion\Mail\MonthlyBookshopMail;
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
        $today="2017-06-29";
        $thisyr=date('Y');
        $lagtime=intval(Setting::where('setting_key','giving_lagtime')->first()->setting_value)
        $reportnums=intval(Setting::where('setting_key','giving_reports')->first()->setting_value)
        $period=12 / $reportnums ;
        if ($reportnums==4){
            
        }
        $endoflastmonth=date('Y-m-t',strtotime("-1 month"));
        $startofperiod=date('Y-m-01',strtotime("-" . $period . " month"));
        dd($startofperiod, $endoflastmonth);
        // Send to bookshop group
        $setting=Setting::where('setting_key','bookshop')->first()->setting_value;
        /*if ($setting){
            $churchemail=Setting::where('setting_key','church_email')->first()->setting_value;
            $group=Group::with('individuals')->where('groupname',$setting)->first();
            if ($group){
                foreach ($group->individuals as $recip){
                    $data['recipient']=$recip->firstname;
                    $data['subject']="Bookshop sales and stock report: " . date("M Y", strtotime("first day of previous month"));
                    $data['sender']=$churchemail;
                    Mail::to($recip->email)->send(new MonthlyBookshopMail($data));
                }
            }
        }*/
    }
}
