<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Models\Group;
use Bishopm\Connexion\Models\Individual;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateGroupRequest;
use Bishopm\Connexion\Http\Requests\UpdateGroupRequest;
use DB, Auth;
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
        $events = $this->group->eventsIncludingUnpublished();
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
        $data=$request->all();
        $data['eventdatetime']=strtotime($data['eventdatetime']);
        $this->group->create($data);

        return redirect()->route('admin.events.index')
            ->withSuccess('New event added');
    }
	
    public function update(Group $event, UpdateGroupRequest $request)
    {
        $data=$request->all();
        $data['eventdatetime']=strtotime($data['eventdatetime']);
        $this->group->update($event,$data);
        return redirect()->route('admin.events.index')->withSuccess('Event has been updated');
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
        $family=Individual::where('household_id',Auth::user()->individual->household_id)->get();
        foreach ($family as $indiv){
            $event->individuals()->detach($indiv->id);
        }
        if (count($request->input('individual_id'))){
            foreach ($request->input('individual_id') as $indiv){
                $event->individuals()->attach($indiv);
            }
            return redirect()->route('comingup')->withSuccess('Sign-up complete :)');
        } else {
            return redirect()->route('comingup')->withSuccess('You have chosen not to attend this event. Sign-up again if you change you mind!');
        }
    }

    public function destroy($id)
    {
        $event=$this->group->find($id);
        $event->delete();
        return redirect()->route('admin.events.index')->withSuccess('Event has been deleted');
    }

    public function showsignup($slug)
    {
        $event=$this->group->findBySlug($slug);
        $attendees=$event->individuals;
        $people=array();
        foreach ($attendees as $attendee){
            $people[]=$attendee->id;
        }
        $leader = $this->individuals->find($event->leader);
        return view('connexion::site.eventsignup',compact('event','leader','people'));
    }

}
