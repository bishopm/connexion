<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Models\Group;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateGroupRequest;
use Bishopm\Connexion\Http\Requests\UpdateGroupRequest;
use DB;

class GroupsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $group;

	public function __construct(GroupsRepository $group, IndividualsRepository $individuals)
    {
        $this->group = $group;
        $this->individuals= $individuals;
    }

	public function index()
	{
        $groups = $this->group->all();
   		return view('connexion::groups.index',compact('groups'));
	}

	public function edit(Group $group)
    {
        return view('connexion::groups.edit', compact('group'));
    }

    public function create()
    {
        return view('connexion::groups.create');
    }

	public function show(Group $group)
	{
        $data['individuals']=$this->individuals->all();
        $data['group']=$group;
        return view('connexion::groups.show',$data);
	}

    public function store(CreateGroupRequest $request)
    {
        $this->group->create($request->all());

        return redirect()->route('admin.groups.index')
            ->withSuccess('New group added');
    }
	
    public function update(Group $group, UpdateGroupRequest $request)
    {
        $this->group->update($group, $request->all());
        return redirect()->route('admin.groups.index')->withSuccess('Group has been updated');
    }

    public function addmember(Group $group,$memberid)
    {
        foreach ($group->pastmembers as $prev){
            if ($prev->id==$memberid){
                $group->individuals()->detach($memberid);
            }
        }
        $group->individuals()->attach($memberid);
    }

    public function removemember(Group $group,$memberid)
    {
        DB::table('group_individual')->where('group_id', $group->id)->where('individual_id', $memberid)->update(array('deleted_at' => DB::raw('NOW()')));
    }

}
