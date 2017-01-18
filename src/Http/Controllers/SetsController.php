<?php

namespace bishopm\base\Http\Controllers;

use Illuminate\Http\Request, Log, DB, Mail, App\Http\Requests, View;
use bishopm\base\Http\Requests\CreateSetRequest, bishopm\base\Http\Requests\UpdateSetRequest;
use App\Http\Controllers\Controller, bishopm\base\Models\Song, bishopm\base\Models\Setitem, bishopm\base\Models\Set, bishopm\base\Models\Service, bishopm\base\Models\Society;

class SetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $soc=1;
        $society=Society::find($soc);
        if ($society){
            $data['society']=$society->society;
        } else {
            return redirect()->route('admin.societies.create')->with('notice','At least one society must be added before adding a set');
        }
        $sets=Set::with('service')->orderBy('servicedate')->get();
        if (count($sets)){
            foreach ($sets as $set){
                $finsets[strtotime($set->servicedate)][$set->service->servicetime]=$set->id;
                $services[]=$set->service->servicetime;
                $servicedates[]=strtotime($set->servicedate);
            }
            foreach (array_unique($servicedates) as $sd){
                foreach(array_unique($services) as $ss){
                    if (!array_key_exists($ss, $finsets[$sd])){
                        $finsets[$sd][$ss]="";
                    }
                }
                ksort($finsets[$sd]);
            }
            $data['sets']=$finsets;
            $data['services']=array_unique($services);
            asort($data['services']);
        } else {
            $data['sets']=array();
            $data['services']=array();
        }
        return view('base::sets.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $soc=1;
        $data['sunday']=date("Y-m-d",strtotime("next Sunday"));
        $data['services']=Service::where('society_id','=',$soc)->orderBy('servicetime')->get();
        if (!count($data['services'])){
            return redirect()->route('admin.societies.index')->with('notice','At least one service must be added before adding a set. Click a society below to add a new service');
        }
        $data['society']=Society::find($soc)->society;
        return view('base::sets.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(CreateSetRequest $request)
    {
        $checkset=Set::where('servicedate','=',$request->servicedate)->where('service_id','=',$request->service_id)->first();
        if (count($checkset)){
            $set=$checkset;
        } else {
            $set=Set::create($request->all());
        }
        return redirect()->route('admin.sets.index')->withSuccess('New set added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data['items']=Setitem::with('song','set')->where('set_id','=',$id)->get();
        $allids=array();
        foreach ($data['items'] as $item){
            $allids[]=$item->song->id;
        }
        $data['set']=Set::find($id);
        if (count($allids)){
            $data['songs']=Song::whereNotIn('id',$allids)->orderBy('title')->select('title','id')->get();
        } else {
            $data['songs']=Song::orderBy('title')->select('title','id')->get();
        }
        return view('base::sets.show',$data);
    }

    public function showapi($id)
    {
        $data['set']=Set::find($id);
        $data['service']=$data['set']->service->service;
        $items=Setitem::with('song','set')->where('set_id','=',$id)->orderBy('itemorder')->get();
        $data['songs']=array();
        $allids=array();
        foreach ($items as $item){
            $dum['title']=$item->song->title;
            $dum['id']=$item->id;
            //$dum['url']=url('/') . "/admin/worship/songs/" . $item->id;
            $data['songs'][]=$dum;
            $allids[]=$item->song->id;
        }
        if (count($allids)){
            $data['newsongs']=Song::whereNotIn('id',$allids)->orderBy('title')->select('title','id')->get();
        } else {
            $data['newsongs']=Song::orderBy('title')->select('title','id')->get();
        }
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function update($id, UpdateSetRequest $request)
    {
    }

    public function updateapi($id, Request $request)
    {
        $items=$request->all();
        foreach ($items as $key=>$item){
            $id=$item['id'];
            $dum=Setitem::find($id);
            $dum->itemorder=$key;
            $dum->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
    }

    public function sendEmail(Request $request) {
		$message = nl2br($request->message);
        $sendername=auth()->user()->name;
        $senderemail=auth()->user()->email;
		Mail::queue('messages.message', array('msg' => $message), function($message) use ($sendername,$senderemail){
	    	$message->from($senderemail, $sendername);
			$message->to('info@umc.org.za','Janet Botes');
            $message->cc($senderemail,$sendername);
			$message->replyTo($senderemail);
			$message->subject("Songs for order of of service");
		});
        return redirect(url('/') . '/sets')->with('okmessage','Email has been sent to the church office and copied to you');
    }
}
