<?php

namespace bishopm\base\Http\Controllers;

use Illuminate\Http\Request, Log, DB, Mail;
use App\Http\Requests, View, bishopm\base\Http\Requests\SetsRequest;
use App\Http\Controllers\Controller, Helpers, bishopm\base\Models\Song, bishopm\base\Models\Setitem, bishopm\base\Models\Set, bishopm\base\Models\Service;

class SetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sets=Set::with('service')->orderBy('servicedate')->get();
        foreach ($sets as $ts){
            $data['sets'][$ts->service->service][strtotime($ts->servicedate)]="<a href=\"sets/" . $ts->id . "\">" . date("d M Y",strtotime($ts->servicedate)) . "</a>";
            krsort($data['sets'][$ts->service->service]);
        }
        if (isset($data['sets'])){
            ksort($data['sets']);
        } else {
            $data['sets']="";
        }
        return view('sets.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (Helpers::perm('edit')){
            $data['sunday']=date("Y-m-d",strtotime("next Sunday"));
            $data['services']=Service::orderBy('service')->get();
            return view('sets.create',$data);
        } else {
            return view('shared.unauthorised');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(SetsRequest $request)
    {
        $checkset=Set::where('servicedate','=',$request->servicedate)->where('service_id','=',$request->service_id)->first();
        if (count($checkset)){
            $set=$checkset;
        } else {
            $set=Set::create($request->all());
        }
        return redirect('sets/' . $set->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        if (Helpers::perm('edit')){
            $data['items']=Setitem::with('song','set')->where('set_id','=',$id)->get();
            $data['set']=Set::find($id);
            return view('sets.show',$data);
        } else {
            return view('shared.unauthorised');
        }
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
            $data['songs'][]=$dum;
            $allids[]=$item->song->id;
        }
        if (count($allids)){
            $data['newsongs']=Song::whereNotIn('id',$allids)->orderBy('title')->get();
        } else {
            $data['newsongs']=Song::orderBy('title')->get();
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
        if (!Helpers::perm('edit')){
            return view('shared.unauthorised');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function update($id, SetsRequest $request)
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
