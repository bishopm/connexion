<?php

namespace Bishopm\Connexion\Http\Controllers;

use Illuminate\Http\Request, Bishopm\Connexion\Models\Society, Helpers;
use Bishopm\Connexion\Http\Requests\MeetingsRequest, Bishopm\Connexion\Models\Meeting;
use Bishopm\Connexion\Http\Controllers\Controller, Redirect, Auth;

class MeetingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($year="")
    {
        if (in_array(Auth::user()->individual_id,explode(',',Helpers::getSetting('site_editors')))){
            if ($year==""){
                $year=date("Y");
            }
            $meetings=Meeting::orderBy('meetingdatetime','DESC')->get();
            $data['year']=$year;
            if ($year){
                foreach ($meetings as $meeting){
                    if (date("Y",$meeting->meetingdatetime)==$year){
                        $data['meetings'][]=$meeting;
                    }
                }
            } else {
                $data['meetings']=$meetings;
            }
            return view('meetings.index',$data);
        } else {
            return view("shared.unauthorised");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (in_array(Auth::user()->individual_id,explode(',',Helpers::getSetting('site_editors')))){
            $data['societies']=Society::orderBy('society')->get();
            return view('meetings.create',$data);
        } else {
            return view("shared.unauthorised");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeetingsRequest $request)
    {
       $meeting=Meeting::create($request->except('circuitname','meetingdatetime'));
       $meeting->meetingdatetime=strtotime($request->input('meetingdatetime'));
       $meeting->save();
       return Redirect::route('meetings.index')->with('okmessage','New meeting has been added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (in_array(Auth::user()->individual_id,explode(',',Helpers::getSetting('site_editors')))){
            $data['meeting']=Meeting::find($id);
            $data['meetingdatetime']=date("Y-m-d H:i",$data['meeting']->meetingdatetime);
            $data['societies']=Society::all();
            return view('meetings.edit',$data);
        } else {
            return view("shared.unauthorised");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MeetingsRequest $request, $id)
    {
       $meeting=Meeting::find($id);
       $meeting=$meeting->fill($request->except('meetingdatetime'));
       $meeting->meetingdatetime=strtotime($request->input('meetingdatetime'));
       $meeting->save();
       return Redirect::route('meetings.index')->with('okmessage','Data updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
