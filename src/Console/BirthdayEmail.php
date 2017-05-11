<?php

namespace Bishopm\Connexion\Console;

use Illuminate\Console\Command, Mail;
use Bishopm\Connexion\Models\Individual, Bishopm\Connexion\Models\Household, Bishopm\Connexion\Models\Specialday, Bishopm\Connexion\Models\Group, DB, Bishopm\Connexion\Models\Society;

class BirthdayEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'connexion:birthdayemail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly email listing birthdays and anniversaries';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function gethcell($id)
    {
      $indiv=Individual::find($id);
      if ($indiv) {
          return $indiv->firstname . " (" . $indiv->cellphone . ")";
      }
      return "Invalid individual";
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $societies=Society::where('group_birthdays','<>',0)->select('group_birthdays','id','email','society')->get();
        foreach($societies as $soc){
            // Birthdays
            $thisyr=date("Y");
            $mon=strval(date('m-d',strtotime("next Monday")));
            $tue=strval(date('m-d',strtotime("next Monday")+86400));
            $wed=strval(date('m-d',strtotime("next Monday")+172800));
            $thu=strval(date('m-d',strtotime("next Monday")+259200));
            $fri=strval(date('m-d',strtotime("next Monday")+345600));
            $sat=strval(date('m-d',strtotime("next Monday")+432000));
            $sun=strval(date('m-d',strtotime("next Monday")+518400));
            $msg="Birthdays for the week: (starting " . $thisyr . "-" . $mon . ")<br><br>";
            $days=array($mon,$tue,$wed,$thu,$fri,$sat,$sun);
            //DB::enableQueryLog();
            $birthdays=Individual::join('households', 'household_id', '=', 'households.id')->where('households.society_id','=',$soc->id)->select('individuals.id','homephone','householdcell','cellphone','firstname','surname',DB::raw('substr(birthdate, 6, 5) as bd'))->wherein(DB::raw('substr(birthdate, 6, 5)'),$days)->orderBy(DB::raw('substr(birthdate, 6, 5)'))->get();
            //Log::debug(DB::getQueryLog());
            foreach($birthdays as $bday){
              $msg=$msg . date("D d M",strtotime($thisyr . "-" . $bday->bd)) . " " . $bday->firstname . " " . $bday->surname . ":";
              if ($bday->cellphone){
                  $msg=$msg . " Cellphone: " . $bday->cellphone;
              }
              if ($bday->homephone){
                 $msg=$msg . " Homephone: " . $bday->homephone;
              }
              if (($bday->householdcell) and ($bday->householdcell<>$bday->id)){
                  $msg=$msg . " Household cellphone: " . self::gethcell($bday->householdcell);
              }
              $msg=$msg . "<br>";
              //Log::notice($bday->surname . ", " . $bday->firstname);
            }
            $anniversaries=Specialday::join('households', 'household_id', '=', 'households.id')->select('homephone','householdcell','addressee','household_id','anntype','details',DB::raw('substr(anniversarydate, 6, 5) as ad'))->wherein(DB::raw('substr(anniversarydate, 6, 5)'),$days)->orderBy(DB::raw('substr(anniversarydate, 6, 5)'))->get();
            $msg = $msg . "<br>" . "Anniversaries" . "<br><br>";
            foreach ($anniversaries as $ann){
              $msg=$msg . date("D d M",strtotime($thisyr . "-" . $ann->ad)) . " (" . $ann->addressee . ". " . ucfirst($ann->anntype) . ": " . $ann->details. ")";
              if ($ann->homephone){
                 $msg=$msg . " Homephone: " . $ann->homephone;
              }
              if ($ann->householdcell){
                  $msg=$msg . " Household cellphone: " . self::gethcell($ann->householdcell);
              }
              $msg=$msg. "<br>";
            }
            $group=Group::with('individual')->find($soc->group_birthdays);
            foreach ($group->individual as $recip){
              $fname=$recip->firstname;
              $name=$recip->firstname . " " . $recip->surname;
              $email=$recip->email;
              $subject="Birthday email from " . $soc->society . " Methodist Church";
              Mail::queue('messages.message', array('msg' => "Good morning, " . $fname . " :)<br><br>" . $msg), function($message) use ($name,$email,$subject,$soc){
      		    	$message->from($soc->email, $soc->society . " Methodist Church");
      					$message->to($email,$name);
      					$message->replyTo($email);
      					$message->subject($subject);
    			});
            }
        }
    }
}
