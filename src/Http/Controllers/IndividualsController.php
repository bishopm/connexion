<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\IndividualsRepository;
use bishopm\base\Repositories\GroupsRepository;
use bishopm\base\Models\Individual;
use bishopm\base\Models\Group;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateIndividualRequest;
use bishopm\base\Http\Requests\UpdateIndividualRequest;
use DB, MediaUploader;
use Cartalyst\Tags\IlluminateTag as Tag;

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
   		return view('base::individuals.index',compact('individuals'));
	}

	public function edit($household,Individual $individual)
    {
        $media=Individual::find($individual->id)->getMedia('image')->first();
        return view('base::individuals.edit', compact('individual','media'));
    }

    public function create($household)
    {
        return view('base::individuals.create', compact('household'));
    }

	public function show(Individual $individual)
	{
		return $individual;
	}

    public function store(CreateIndividualRequest $request)
    {
        $individual=$this->individual->create($request->except('image'));
        if ($request->file('image')){
            $fname=$individual->id;
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('individuals')->useFilename($fname)->upload();
            $individual->attachMedia($media, 'image');
        }
        return redirect()->route('admin.households.show',$request->household_id)
            ->withSuccess('New individual added');
    }

    public function update($household, Individual $individual, UpdateIndividualRequest $request)
    {
        $this->individual->update($individual, $request->except('image'));
        if ($request->file('image')){
            $fname=$individual->id;
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('individuals')->useFilename($fname)->upload();
            $individual->attachMedia($media, 'image');
        }
        return redirect()->route('admin.households.show',$individual->household_id)->withSuccess('Individual has been updated');
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

}
