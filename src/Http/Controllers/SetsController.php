<?php

namespace Bishopm\Connexion\Http\Controllers;

use Illuminate\Http\Request, Log, DB, Mail, App\Http\Requests, View;
use Bishopm\Connexion\Http\Requests\CreateSetRequest, Bishopm\Connexion\Http\Requests\UpdateSetRequest;
use App\Http\Controllers\Controller, Bishopm\Connexion\Models\Song, Bishopm\Connexion\Models\Setitem, Bishopm\Connexion\Models\Set, Bishopm\Connexion\Models\Service, Bishopm\Connexion\Models\Society, Bishopm\Connexion\Models\Setting, Bishopm\Connexion\Models\User;
use Bishopm\Connexion\Notifications\WorshipSetNotification;

class SetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $soc=Setting::where('setting_key','society_name')->first()->setting_value;
        $society=Society::where('society',$soc)->first();
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
        return view('connexion::sets.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $soc=Setting::where('setting_key','society_name')->first()->setting_value;
        $data['society']=Society::where('society',$soc)->first();
        $data['sunday']=date("Y-m-d",strtotime("next Sunday"));
        $data['services']=Service::where('society_id','=',$data['society']->id)->orderBy('servicetime')->get();
        if (!count($data['services'])){
            return redirect()->route('admin.societies.index')->with('notice','At least one service must be added before adding a set. Click a society below to add a new service');
        }
        return view('connexion::sets.create',$data);
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
        return view('connexion::sets.show',$data);
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
        $admin_id=Setting::where('setting_key','worship_administrator')->first()->setting_value;
        $admin=User::where('name',$admin_id)->first();
		$message = nl2br($request->message);
        $sender=auth()->user();
        $admin->notify(new WorshipSetNotification($message));
        $sender->notify(new WorshipSetNotification($message));
        return redirect(url('/admin/worship') . '/sets')->withSuccess('Set details have been sent to ' . $admin->individual->firstname . ' and copied to you');
    }
}
