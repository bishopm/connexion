<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\HouseholdsRepository;
use bishopm\base\Repositories\GroupsRepository;
use bishopm\base\Models\Household;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateHouseholdRequest;
use bishopm\base\Http\Requests\UpdateHouseholdRequest;

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
   		return view('base::households.index',compact('households'));
	}

	public function edit(Household $household)
    {
        return view('base::households.edit', compact('household'));
    }

    public function create()
    {
        return view('base::households.create');
    }

	public function show(Household $household)
	{
        $data['pastors'][0]=['id'=>1,'firstname'=>'Michael','surname'=>'Bishop'];
        $data['groups']=$this->groups->all();
        $data['household']=$household;
        return view('base::households.show',$data);
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
        return redirect()->route('admin.households.index')->withSuccess('Household has been updated');
    }

}
 