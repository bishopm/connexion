<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\HouseholdsRepository;
use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Models\Individual;
use Bishopm\Connexion\Models\Household;
use Bishopm\Connexion\Models\Specialday;
use Bishopm\Connexion\Models\Group;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateIndividualRequest;
use Bishopm\Connexion\Http\Requests\UpdateIndividualRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use JWTAuth;

class IndividualsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $individual;
    private $group;
    private $households;

    public function __construct(IndividualsRepository $individual, GroupsRepository $group, HouseholdsRepository $households)
    {
        $this->individual = $individual;
        $this->group = $group;
        $this->households = $households;
    }

    public function index()
    {
        $individuals = $this->individual->all();
        return view('connexion::individuals.index', compact('individuals'));
    }

    public function edit($household, Individual $individual)
    {
        $media='';
        $households=$this->households->dropdown();
        return view('connexion::individuals.edit', compact('individual', 'media', 'households'));
    }

    public function giving($household, Individual $individual, $pg)
    {
        $individual->giving=$pg;
        $individual->save();
        return redirect()->back();
    }

    public function create(Household $household)
    {
        return view('connexion::individuals.create', compact('household'));
    }

    public function show(Individual $individual)
    {
        return $individual;
    }

    public function store(CreateIndividualRequest $request)
    {
        $individual=$this->individual->create($request->all());
        $household=Household::find($individual->household_id);
        if (($household->householdcell==0) and ($individual->cellphone<>'')) {
            $household->householdcell=$individual->id;
            $household->save();
        }
        if ($individual->image) {
            $folder=base_path() . '/storage/app/public/individuals/';
            $newfolder=$folder . $individual->id;
            if (!file_exists($newfolder)) {
                mkdir($newfolder);
            }
            $move = File::move($folder . $individual->image, $newfolder . '/' . $individual->image);
        }
        if ($request->exists('notes')) {
            return redirect()->route('admin.households.show', $request->household_id)
            ->withSuccess('New individual added');
        } else {
            return redirect()->route('mydetails')->withSuccess('Individual was added');
        }
    }

    public function update($household, Individual $individual, UpdateIndividualRequest $request)
    {
        $this->individual->update($individual, $request->all());
        if ($request->exists('notes')) {
            return redirect()->route('admin.households.show', $individual->household_id)->withSuccess('Individual has been updated');
        } else {
            return redirect()->route('mydetails')->withSuccess('Individual has been updated');
        }
    }

    public function addgroup($individual, $group)
    {
        $individual=$this->individual->find($individual);
        $group=$this->group->find($group);
        foreach ($individual->pastgroups as $prev) {
            if ($prev->id==$group->id) {
                $group->individuals()->detach($individual->id);
            }
        }
        $group->individuals()->attach($individual->id);
    }

    public function removegroup($member, $group)
    {
        DB::table('group_individual')->where('group_id', $group)->where('individual_id', $member)->update(array('deleted_at' => DB::raw('NOW()')));
    }

    public function addtag($member, $tag)
    {
        $indiv=Individual::find($member);
        $indiv->tag($tag);
    }

    public function removetag($member, $tag)
    {
        $indiv=Individual::find($member);
        $indiv->untag($tag);
    }

    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $individuals=$this->individual->forEmail($email);
        if ($individuals<>"No data") {
            $family=array();
            foreach ($individuals as $indiv) {
                if ($indiv->user) {
                    $indiv->firstname=$indiv->firstname . " (already registered)";
                    $indiv->id=$indiv->id*-1;
                }
                $family[]=$indiv;
            }
            return json_encode($family);
        } else {
            return "No data";
        }
    }

    public function destroy(Request $request, $household, $id)
    {
        $individual=$this->individual->find($id);
        if ($request->deltype=="death") {
            $ann=Specialday::create(['household_id' => $individual->household_id, 'anniversarytype'=>'death', 'anniversarydate'=>$request->deathdate, 'details'=>$individual->firstname . '\'s death']);
            $individual->forceDelete();
        } elseif ($request->deltype=="archive") {
            $individual->delete();
        } elseif ($request->deltype=="delete") {
            $individual->forceDelete();
        }
        return redirect()->route('admin.households.show', $household)->withSuccess('Individual has been deleted');
    }

    public function api_individual()
    {
        $user = JWTAuth::parseToken()->toUser();
        $indiv=Individual::with('user', 'groups')->where('id', $user->individual_id)->first();
        $groups=array();
        foreach ($indiv->groups as $group) {
            $groups[$group->grouptype][]=$group;
        }
        $indiv->sortedgroups=$groups;
        $indiv->avatar="http://umc.org.za/public/storage/individuals/" . $indiv->id . "/" . $indiv->image;
        return $indiv;
    }
}
