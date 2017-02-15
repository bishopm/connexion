<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\MeetingsRepository;
use Bishopm\Connexion\Repositories\SocietiesRepository;
use Bishopm\Connexion\Models\Meeting;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateMeetingRequest;
use Bishopm\Connexion\Http\Requests\UpdateMeetingRequest;

class MeetingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $meeting,$societies;

	public function __construct(MeetingsRepository $meeting, SocietiesRepository $societies)
    {
        $this->meeting = $meeting;
        $this->societies = $societies;
    }

	public function index()
	{
        $meetings = $this->meeting->all();
   		return view('connexion::meetings.index',compact('meetings'));
	}

	public function edit(Meeting $meeting)
    {
        return view('connexion::meetings.edit', compact('meeting'));
    }

    public function create()
    {
        $societies = $this->societies->all();
        return view('connexion::meetings.create',compact('societies'));
    }

	public function show(Meeting $meeting)
	{
        $data['meeting']=$meeting;
        return view('connexion::meetings.show',$data);
	}

    public function store(CreateMeetingRequest $request)
    {
        $this->meeting->create($request->all());

        return redirect()->route('admin.meetings.index')
            ->withSuccess('New meeting added');
    }
	
    public function update(Meeting $meeting, UpdateMeetingRequest $request)
    {
        $this->meeting->update($meeting, $request->all());
        return redirect()->route('admin.meetings.index')->withSuccess('Meeting has been updated');
    }

}