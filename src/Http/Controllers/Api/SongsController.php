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
        if ($request->tags) {
            $tags = implode(",", $request->tags);
            $songs = Song::whereTag($tags)->whereIn('musictype', $request->musictype)->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
                $query->orWhere('words', 'like', '%' . $request->search . '%');
                $query->orWhere('author', 'like', '%' . $request->search . '%');
            })->orderBy('title')->get();
        } else {
            $songs = Song::whereIn('musictype', $request->musictype)->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
                $query->orWhere('words', 'like', '%' . $request->search . '%');
                $query->orWhere('author', 'like', '%' . $request->search . '%');
            })->orderBy('title')->get();
        }
        return $songs;
    }

    public function allsongs()
    {
        return Song::orderBy('title')->get();
    }

    public function tags()
    {
        $tags = Song::allTags()->orderBy('name')->get();
        $data = array();
        foreach ($tags as $tag) {
            $data[] = $tag->name;
        }
        return $data;
    }

    public function tag($slug)
    {
        return Song::withTag($slug)->orderBy('title')->get();
    }

    public function tagstore()
    {
        return Song::withTag($slug)->orderBy('title')->get();
    }

    public function news()
    {
        $data['contemporary'] = Song::where('musictype','contemporary')->orderBy('created_at','DESC')->select('title','id','author','created_at')->take(10)->get();
        $data['hymns'] = Song::where('musictype','hymn')->orderBy('created_at','DESC')->select('title','id','author','created_at')->take(10)->get();
        $data['liturgy'] = Song::where('musictype','liturgy')->orderBy('created_at','DESC')->select('title','id','author','created_at')->take(10)->get();
        return $data;
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
        $categories = array();
        foreach ($song->tags as $tag) {
            $categories[] = $tag->name;
        }
        $song->categories = $categories;
        $song->history = $allh;
        $atags = Song::allTags()->orderBy('name')->get();
        $alltags = array();
        foreach ($atags as $atag) {
            $alltags[] = $atag->name;
        }
        $song->alltags = $alltags;
        return $song;
    }

    public function update(Request $request)
    {
        $song = Song::find($request->song['id']);
        $song->lyrics = $request->song['lyrics'];
        $song->key = $request->song['key'];
        $song->title = $request->song['title'];
        $song->author = $request->song['author'];
        $song->musictype = $request->song['musictype'];
        $song->audio = $request->song['audio'];
        $song->save();
        $song->setTags($request->song['categories']);
        return "Song updated";
    }

    public function store(Request $request)
    {
        $song = Song::create([
            'lyrics' => $request->song['lyrics'],
            'key' => $request->song['key'],
            'title' => $request->song['title'],
            'author' => $request->song['author'],
            'musictype' => $request->song['musictype'],
            'audio' => $request->song['audio']
        ]);
        $song->setTags($request->song['categories']);
        return $song->id;
    }
}
