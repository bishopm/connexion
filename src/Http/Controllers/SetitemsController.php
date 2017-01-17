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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteitem($id)
    {
        Setitem::find($id)->delete();
    }

}
