<?php

namespace Bishopm\Connexion\Http\Controllers\Web;

use Illuminate\Http\Request;
use Log;
use DB;
use Auth;
use App\Http\Requests;
use View;
use Bishopm\Connexion\Http\Requests\SetsRequest;
use App\Http\Controllers\Controller;
use Helpers;
use Bishopm\Connexion\Models\Song;
use Bishopm\Connexion\Models\Setitem;
use Bishopm\Connexion\Models\Set;
use Bishopm\Connexion\Models\Service;
use Bishopm\Connexion\Models\Setting;
use Bishopm\Connexion\Models\User;
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


    public function additem($set, $song)
    {
        $setitem=new Setitem;
        $setitem->set_id=$set;
        $setitem->song_id=$song;
        $setitem->itemorder=count(Set::find($set)->setitems)+1;
        $setitem->itemtype='song';
        $setitem->save();
        $fin['id']=$setitem->id;
        $fin['title']=Song::find($song)->title;
        $fin['type']='song';
        $fin['songid']=$song;
        return redirect()->route('admin.songs.show', $song)
            ->withSuccess('Added to set');
    }

    public function addorderitem(Request $request)
    {
        $setitem=new Setitem;
        $setitem->set_id=$request->set_id;
        $setitem->song_id=0;
        $setitem->itemorder=count(Set::find($request->set_id)->setitems)+1;
        $setitem->description=$request->description;
        $setitem->itemtype=$request->itemtype;
        $setitem->save();
        $fin['id']=$setitem->id;
        $fin['type']=$request->itemtype;
        $fin['title']=$request->description;
        $fin['songid']=0;
        return redirect()->route('admin.sets.show', $request->set_id)
            ->withSuccess('Added to set');
    }

    public function getitems($set)
    {
        $setitems=Setitem::with('song')->where('set_id', '=', $set)->orderBy('itemorder')->get();
        $fin=array();
        foreach ($setitems as $setitem) {
            $dum['type']=$setitem->itemtype;
            if ($dum['type']<>'song') {
                if (isset($setitem->description)) {
                    $dum['title']=$setitem->description;
                } else {
                    $dum['title']=ucfirst($dum['type']);
                }
            } else {
                $dum['title']=$setitem->song->title;
            }
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
        $msg="Hi " . $admin . "\n\nHere is the order of service for the " . $fullset->servicetime . " service on " . $fullset->servicedate . ":\n\n";
        $setitems=Setitem::with('song')->where('set_id', '=', $set)->orderBy('itemorder')->get();
        foreach ($setitems as $setitem) {
            if ($setitem->itemtype=="song") {
                $msg.=$setitem->song->title . "\n";
            } else {
                if ($setitem->itemtype=="other") {
                    $msg.=$setitem->description . "\n";
                } else {
                    $msg.=ucfirst($setitem->itemtype);
                    if ($setitem->description) {
                        $msg.=": " . $setitem->description . "\n";
                    } else {
                        $msg.="\n";
                    }
                }
            }
        }
        $msg.="\nThanks!\n\n";
        $msg.=Auth::user()->individual->firstname;
        return $msg;
    }

    public function reorderset(Request $request)
    {
        $items=json_decode($request->items);
        $loop=0;
        foreach ($items as $item) {
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
        $setitems=Setitem::where('set_id', '=', $set)->orderBy('itemorder')->get();
        $loop=0;
        foreach ($setitems as $item) {
            $item->itemorder=$loop;
            $loop++;
            $item->save();
        }
    }
}
