<?php

namespace Bishopm\Connexion\Http\Controllers;

use Illuminate\Http\Request, Log, DB, Auth;
use App\Http\Requests, View, Bishopm\Connexion\Http\Requests\SetsRequest;
use App\Http\Controllers\Controller, Helpers, Bishopm\Connexion\Models\Song, Bishopm\Connexion\Models\Setitem, Bishopm\Connexion\Models\Set, Bishopm\Connexion\Models\Service;
use Bishopm\Connexion\Models\Setting, Bishopm\Connexion\Models\User;
use Bishopm\Connexion\Repositories\SettingsRepository;

class SetitemsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

	private $setting;

	public function __construct(SettingsRepository $setting)
    {
        $this->setting = $setting;
    }


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
        $fin=array();
        foreach ($setitems as $setitem){
            $dum['title']=$setitem->song->title;
            $dum['id']=$setitem->id;
            $fin[]=$dum;
        }
        return $fin;
    }

    public function getmessage($set)
    {
        $admin_id=$this->setting->getkey('worship_administrator');
        $admin=User::find($admin_id)->individual->firstname;
        $fullset=Set::find($set);
        $msg="Hi " . $admin . "\n\nHere are the songs for the " . $fullset->servicetime . " service on " . $fullset->servicedate . ":\n\n";
        $setitems=Setitem::with('song')->where('set_id','=',$set)->orderBy('itemorder')->get();
        foreach ($setitems as $setitem){
            $msg.=$setitem->song->title . "\n";
        }
        $msg.="\nThanks!\n\n";
        $msg.=Auth::user()->individual->firstname;
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
