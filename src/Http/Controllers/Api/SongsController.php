<?php

namespace Bishopm\Connexion\Http\Controllers\Api;

use Illuminate\Http\Request;
use Bishopm\Connexion\Models\Gchord;
use Bishopm\Connexion\Models\User;
use Bishopm\Connexion\Models\Song;
use Auth;
use Bishopm\Connexion\Models\Set;
use Bishopm\Connexion\Models\Setitem;
use View;
use Redirect;
use DB;
use App\Http\Controllers\Controller;

class SongsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $songs = Song::whereIn('musictype', $request->musictype)->where(function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->search . '%');
            $query->orWhere('words', 'like', '%' . $request->search . '%');
            $query->orWhere('author', 'like', '%' . $request->search . '%');
        })->orderBy('title')->get();
        return $songs;
    }

    public function allsongs()
    {
        return Song::orderBy('title')->get();
    }

    public function show($id)
    {
        $song = Song::find($id);
        $history=Setitem::with('set')->where('song_id', '=', $id)->get();
        $allh=array();
        foreach ($history as $sitem) {
            $allh[$sitem->set->servicetime][]=$sitem->set->servicedate;
        }
        ksort($allh);
        foreach ($allh as $kk=>$ss) {
            rsort($allh[$kk]);
        }   
        $song->history = $allh;
        return $song;
    }

    public function update(Request $request)
    {
        $song = Song::find($request->song['id']);
        $song->lyrics = $request->song['lyrics'];
        $song->title = $request->song['title'];
        $song->author = $request->song['author'];
        $song->musictype = $request->song['musictype'];
        $song->audio = $request->song['audio'];
        $song->save();
        return "Song updated";
    }
}
