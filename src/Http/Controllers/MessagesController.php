<?php

namespace Bishopm\Connexion\Http\Controllers;

use App\Http\Controllers\Controller;
use Bishopm\Connexion\Mail\GenericMail;
use Illuminate\Support\Facades\Mail;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Http\Requests\MessageRequest;

class MessagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    private $groups, $individuals;

    public function __construct(GroupsRepository $groups, IndividualsRepository $individuals)
    {
        $this->groups = $groups;
        $this->individuals = $individuals;
    }


	public function create()
	{
        $data['groups']=$this->groups->all();
        $data['individuals']=$this->individuals->all();
   		return view('connexion::messages.create',$data);
	}

    public function store(MessageRequest $request)
    {
        $recipients=$this->getrecipients($request->groups,$request->individuals,$request->grouprec);
        if ($request->msgtype=="email"){
            $results=$this->sendemail($request,$recipients);
        } elseif ($request->msgtype=="sms") {
            $results=$this->sendsms($request,$recipients);
        }
        return view('connexion::messages.results',compact('recipients'));
    }

    protected function getrecipients($groups,$individuals,$grouprec)
    {
        $recipients=array();
        if ($grouprec=="allchurchmembers"){
            $indivs=$this->individuals->allchurchmembers();
            foreach ($indivs as $indiv){
                if ((null !== $indiv->household->householdcell) and ($indiv->household->householdcell==$indiv->id)){
                    $recipients[$indiv->household_id][$indiv->id]['name']=$indiv->fullname;
                    $recipients[$indiv->household_id][$indiv->id]['email']=$indiv->email;
                    $recipients[$indiv->household_id][$indiv->id]['cellphone']=$indiv->cellphone;
                }
            }
        } elseif ($grouprec=="everyone"){
            $indivs=$this->individuals->everyone();
            foreach ($indivs as $indiv){
                if ((null !== $indiv->household->householdcell) and ($indiv->household->householdcell==$indiv->id)){
                    $recipients[$indiv->household_id][$indiv->id]['name']=$indiv->fullname;
                    $recipients[$indiv->household_id][$indiv->id]['email']=$indiv->email;
                    $recipients[$indiv->household_id][$indiv->id]['cellphone']=$indiv->cellphone;
                }
            }
        } else {
            if (null!==$groups){
                foreach ($groups as $group){
                    if ($grouprec=="leadersonly"){
                        $indiv=$this->individuals->find($this->groups->find($group)->leader);
                        $recipients[$indiv->household_id][$indiv->id]['name']=$indiv->fullname;
                        $recipients[$indiv->household_id][$indiv->id]['email']=$indiv->email;
                        $recipients[$indiv->household_id][$indiv->id]['cellphone']=$indiv->cellphone;
                    } else {
                        $indivs=$this->groups->find($group)->individuals;
                        foreach ($indivs as $indiv){
                            $recipients[$indiv->household_id][$indiv->id]['name']=$indiv->fullname;
                            $recipients[$indiv->household_id][$indiv->id]['email']=$indiv->email;
                            $recipients[$indiv->household_id][$indiv->id]['cellphone']=$indiv->cellphone;
                        }
                    }
                }
            }
            if (null!==$individuals){
                foreach ($individuals as $indi){
                    $recipients[$indi->household_id][$indi->id]['name']=$indi->fullname;
                    $recipients[$indi->household_id][$indi->id]['email']=$indi->email;
                    $recipients[$indi->household_id][$indi->id]['cellphone']=$indi->cellphone;
                }
            }
        }
        return $recipients;
    }

    protected function sendemail($data,$recipients)
    {
        foreach ($recipients as $household){
            foreach ($household as $indiv){
                Mail::to($indiv['email'])->send(new GenericMail($data));
            }
        }   
    }

    protected function sendsms($data,$recipients)
    {
        return "SMS not implemented yet!";
        foreach ($recipients as $household){
            foreach ($household as $indiv){
                //Mail::to($indiv['email'])->send(new GenericMail($data));
            }
        }   
    }
}