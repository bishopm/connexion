<?php

namespace bishopm\base\Http\Controllers;

use Illuminate\Http\Request, Log, DB;
use App\Http\Requests, View, bishopm\base\Http\Requests\SetsRequest;
use App\Http\Controllers\Controller, Helpers, bishopm\base\Models\Song, bishopm\base\Models\Setitem, bishopm\base\Models\Set, bishopm\base\Models\Service;

class SetitemsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function additem($set,$song)
    {
        $setitem=new Setitem;
        $setitem->set_id=$set;
        $setitem->song_id=$song;
        $setitem->itemorder=count(Set::find($set)->setitems)+1;
        $setitem->save();
        $fin['id']=$setitem->id;
        $fin['title']=Song::find($song)->title;
        $fin['songid']=$song;
        return $fin;
    }

    public function getitems($set)
    {
        $setitems=Setitem::with('song')->where('set_id','=',$set)->orderBy('itemorder')->get();
        foreach ($setitems as $setitem){
            $dum['title']=$setitem->song->title;
            $dum['id']=$setitem->id;
            $fin[]=$dum;
        }
        return $fin;
    }

    public function getmessage($set)
    {
        $fullset=Set::find($set);
        $msg="Hi Janet\n\nHere are the songs for the " . $fullset->service->servicetime . " service on " . $fullset->servicedate . ":\n\n";
        $setitems=Setitem::with('song')->where('set_id','=',$set)->orderBy('itemorder')->get();
        foreach ($setitems as $setitem){
            $msg.=$setitem->song->title . "\n";
        }
        $msg.="\nThanks!";
        return $msg;
    }

    public function reorderset(Request $request)
    {
        $items=json_decode($request->items);
        $loop=0;
        foreach ($items as $item){
            $setitem=Setitem::find($item->id);
            $setitem->itemorder=$loop;
            $loop++;
            $setitem->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteitem($id)
    {
        $setitem=Setitem::find($id);
        $set=$setitem->set_id;
        $setitem->delete();
        $setitems=Setitem::where('set_id','=',$set)->orderBy('itemorder')->get();
        $loop=0;
        foreach ($setitems as $item){
            $item->itemorder=$loop;
            $loop++;
            $item->save();   
        }
    }

}
