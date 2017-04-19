<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Models\Individual;
use Bishopm\Connexion\Models\Group;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateIndividualRequest;
use Bishopm\Connexion\Http\Requests\UpdateIndividualRequest;
use DB, Illuminate\Http\Request, Illuminate\Support\Facades\File;

class IndividualsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $individual,$group;

	public function __construct(IndividualsRepository $individual, GroupsRepository $group)
    {
        $this->individual = $individual;
        $this->group = $group;
    }

	public function index()
	{
        $individuals = $this->individual->all();
   		return view('connexion::individuals.index',compact('individuals'));
	}

	public function edit($household,Individual $individual)
    {
        $media=Individual::find($individual->id)->getMedia('image')->first();
        return view('connexion::individuals.edit', compact('individual','media'));
    }

    public function giving($household,Individual $individual, $pg)
    {
        $individual->giving=$pg;
        $individual->save();
        return redirect()->back();
    }    

    public function create($household)
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
        $folder=base_path() . '/storage/app/public/individuals/';
        $newfolder=$folder . $individual->id;
        if (!file_exists($newfolder)){
            mkdir($newfolder);
        }
        $move = File::move($folder . $individual->image, $newfolder . $individual->image);
        if (null!==$request->input('notes')){
            return redirect()->route('admin.households.show',$request->household_id)
            ->withSuccess('New individual added');
        } else {
            return redirect()->route('mydetails')->withSuccess('Individual has added');
        }
    }

    public function update($household, Individual $individual, UpdateIndividualRequest $request)
    {
        $this->individual->update($individual, $request->all());
        if (null!==$request->input('notes')){
            return redirect()->route('admin.households.show',$individual->household_id)->withSuccess('Individual has been updated');
        } else {
            return redirect()->route('mydetails')->withSuccess('Individual has been updated');
        }
    }

    public function addgroup($individual, $group)
    {
        $individual=$this->individual->find($individual);
        $group=$this->group->find($group);
        foreach ($individual->pastgroups as $prev){
            if ($prev->id==$group->id){
                $group->individuals()->detach($individual->id);
            }
        }
        $group->individuals()->attach($individual->id);
    }

    public function removemedia(Individual $individual)
    {
        $media = $individual->getMedia('image');
        $individual->detachMedia($media);
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
        return $individuals;
    }    
}
