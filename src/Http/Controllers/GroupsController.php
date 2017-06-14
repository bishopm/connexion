<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Models\Group;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateGroupRequest;
use Bishopm\Connexion\Http\Requests\UpdateGroupRequest;
use DB;
use Illuminate\Http\Request;

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
        $indivs=$this->individuals->all();
        return view('connexion::groups.edit', compact('group','indivs'));
    }

    public function create()
    {
        $indivs=$this->individuals->all();
        return view('connexion::groups.create',compact('indivs'));
    }

	public function show(Group $group)
	{
        $data['individuals']=$this->individuals->all();
        $data['group']=$group;
        $data['leader']=$this->individuals->find($group->leader);
        return view('connexion::groups.show',$data);
	}

    public function store(CreateGroupRequest $request)
    {
        $group=$this->group->create($request->all());

        return redirect()->route('admin.groups.show',$group->id)
            ->withSuccess('New group added');
    }
	
    public function update(Group $group, UpdateGroupRequest $request)
    {
        if (!isset($request->publish)){
            $request->request->add(['publish'=>0]);
            $this->group->update($group, $request->all());
            return redirect()->route('admin.groups.index')->withSuccess('Group has been updated');
        } elseif ($request->publish=="webedit"){
            $group=$this->group->update($group, $request->except('publish'));
            $group->publish=1;
            $group->save();
            return redirect()->route('webgroup',$group->slug)->withSuccess('Group has been updated');
        } else {
            $this->group->update($group, $request->all());
            return redirect()->route('admin.groups.index')->withSuccess('Group has been updated');
        }
    }

    public function addmember(Group $group,$memberid)
    {
        foreach ($group->pastmembers as $prev){
            if ($prev->id==$memberid){
                $group->individuals()->detach($memberid);
            }
        }
        if (!$group->individuals->contains($memberid)){
            $group->individuals()->attach($memberid);
        }
    }

    public function removemember(Group $group,$memberid)
    {
        DB::table('group_individual')->where('group_id', $group->id)->where('individual_id', $memberid)->update(array('deleted_at' => DB::raw('NOW()')));
    }

    public function signup(Group $group, Request $request){
        foreach ($request->input('individual_id') as $indiv){
            $this->addmember($group,$indiv);
        }
        return redirect()->route('webcourses')->withSuccess('Sign-up complete :)');
    }

    public function destroy($id)
    {
        $group=$this->group->find($id);
        $group->delete();
        return redirect()->route('admin.groups.index')->withSuccess('Group has been deleted');
    }

}
