<?php

namespace Bishopm\Connexion\Http\Controllers\Api;

use Illuminate\Http\Request;
use Bishopm\Connexion\Models\Song;
use Bishopm\Connexion\Models\Set;
use Bishopm\Connexion\Models\Setitem;
use App\Http\Controllers\Controller;

class SetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $sets = Set::orderBy('servicedate', 'DESC')->orderBy('servicetime', 'ASC')->get();
        $data=array();
        $data['times']=array();
        foreach ($sets as $set) {
            $data['sets'][$set->servicedate][$set->servicetime] = $set->id;
            if (!in_array($set->servicetime, $data['times'])) {
                $data['times'][]=$set->servicetime;
            }
        }
        sort($data['times']);
        return $data;
    }

    public function show(Request $request)
    {
        return Set::firstOrCreate(array('servicedate' => $request->servicedate, 'servicetime' => $request->servicetime));
    }

    public function find($id)
    {
        $data['songs'] = Song::orderBy('title')->get();
        $data['set'] = Set::with('setitems.song')->find($id);
        return $data;
    }

    public function addItem(Request $request)
    {
        $setitem = Setitem::create($request->all());
        $data['id'] = $setitem->id;
        $data['title'] = Song::find($request->song_id)->title;
        return $data;
    }

    public function removeItem(Request $request)
    {
        $setitem = Setitem::find($request->id)->delete();
        return "deleted set item";
    }
}
