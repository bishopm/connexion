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

class EventsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $group,$individuals;

	public function __construct(GroupsRepository $group, IndividualsRepository $individuals)
    {
        $this->group = $group;
        $this->individuals= $individuals;
    }

	public function index()
	{
        $events = $this->group->event();
   		return view('connexion::events.index',compact('events'));
	}

	public function edit(Group $event)
    {
        $indivs=$this->individuals->all();
        return view('connexion::events.edit', compact('event','indivs'));
    }

    public function create()
    {
        $indivs=$this->individuals->all();
        return view('connexion::events.create',compact('indivs'));
    }

	public function show(Group $event)
	{
        $data['individuals']=$this->individuals->all();
        $data['event']=$event;
        $data['leader']=$this->individuals->find($event->leader);
        return view('connexion::events.show',$data);
	}

    public function store(CreateGroupRequest $request)
    {
        $request->request->add(['eventdatetime'=>date('Y-m-d H:')]);
        $this->group->create($request->all());

        return redirect()->route('admin.events.index')
            ->withSuccess('New event added');
    }
	
    public function update(Group $event, UpdateGroupRequest $request)
    {
        if (!isset($request->publish)){
            $request->request->add(['publish'=>0]);
            $this->group->update($event, $request->all());
            return redirect()->route('admin.events.index')->withSuccess('Event has been updated');
        } elseif ($request->publish=="webedit"){
            $event=$this->group->update($event, $request->except('publish'));
            $event->publish=1;
            $event->save();
            return redirect()->route('webevent',$event->slug)->withSuccess('Event has been updated');
        } else {
            $this->group->update($event, $request->all());
            return redirect()->route('admin.events.index')->withSuccess('Event has been updated');
        }
    }

    public function addmember(Group $event,$memberid)
    {
        foreach ($event->pastmembers as $prev){
            if ($prev->id==$memberid){
                $event->individuals()->detach($memberid);
            }
        }
        if (!$event->individuals->contains($memberid)){
            $event->individuals()->attach($memberid);
        }
    }

    public function removemember(Group $event,$memberid)
    {
        DB::table('event_individual')->where('event_id', $event->id)->where('individual_id', $memberid)->update(array('deleted_at' => DB::raw('NOW()')));
    }

    public function signup(Group $event, Request $request){
        foreach ($request->input('individual_id') as $indiv){
            $this->addmember($event,$indiv);
        }
        return redirect()->route('webcourses')->withSuccess('Sign-up complete :)');
    }

    public function destroy($id)
    {
        $event=$this->group->find($id);
        $event->delete();
        return redirect()->route('admin.events.index')->withSuccess('Event has been deleted');
    }

}
