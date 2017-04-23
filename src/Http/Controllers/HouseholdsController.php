<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\HouseholdsRepository;
use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Models\Household;
use Bishopm\Connexion\Models\Individual;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateHouseholdRequest;
use Bishopm\Connexion\Http\Requests\UpdateHouseholdRequest;
use Bishopm\Connexion\Models\Setting;

class HouseholdsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $household,$groups;

	public function __construct(HouseholdsRepository $household, GroupsRepository $groups)
    {
        $this->household = $household;
        $this->groups = $groups;
    }

	public function index()
	{
        $households = $this->household->all();
   		return view('connexion::households.index',compact('households'));
	}

	public function edit(Household $household)
    {
        $data['household']=$household;
        foreach ($household->individuals as $indiv){
            if (strlen($indiv->cellphone)==10){
                $data['cellphones'][$indiv->id]['name']=$indiv->firstname;
            }
        }
        return view('connexion::households.edit', $data);
    }

    public function create()
    {
        return view('connexion::households.create');
    }

	public function show(Household $household)
	{
        $pastoralgroup=Setting::where('setting_key','pastoral_group')->first();
        if ($pastoralgroup->setting_value<>''){
            $group=$this->groups->findByName($pastoralgroup->setting_value);
            foreach ($group->individuals as $indiv){
                $dum['id']=$indiv->id;
                $dum['firstname']=$indiv->firstname;
                $dum['surname']=$indiv->surname;
                $data['pastors'][]=$dum;
            }
        }
        $data['groups']=$this->groups->all();
        $data['household']=$household;
        $data['tags']=Individual::allTags()->get();
        foreach ($household->individuals as $indiv){
            if ($indiv->tags){
                foreach ($indiv->tags as $itag){
                    $data['itags'][$indiv->id][]=$itag->name;
                }
            }
            if ($indiv->groups){
                foreach ($indiv->groups as $group){
                    $data['igroups'][$indiv->id][]=$group->id;
                }
            }
        }
        return view('connexion::households.show',$data);
	}

    public function store(CreateHouseholdRequest $request)
    {
        $this->household->create($request->all());

        return redirect()->route('admin.households.index')
            ->withSuccess('New household added');
    }

    public function update(Household $household, UpdateHouseholdRequest $request)
    {
        $this->household->update($household, $request->all());
        if (null!==$request->input('latitude')){
            return redirect()->route('admin.households.index')->withSuccess('Household has been updated');
        } else {
            return redirect()->route('mydetails')->withSuccess('Household has been updated');
        }
    }

}
