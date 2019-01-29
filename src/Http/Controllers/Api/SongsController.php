<?php

namespace Bishopm\Connexion\Http\Controllers\Api;

use Illuminate\Http\Request;
use Bishopm\Connexion\Models\Gchord;
use App\Http\Requests;
use Bishopm\Connexion\Models\User;
use Bishopm\Connexion\Models\Song;
use Auth;
use Bishopm\Connexion\Models\Set;
use Bishopm\Connexion\Models\Setitem;
use View;
use Redirect;
use DB;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\SongsRequest;
use Bishopm\Connexion\Libraries\Fpdf\Fpdf;
use Bishopm\Connexion\Models\Roster;
use Bishopm\Connexion\Models\Setting;
use Bishopm\Connexion\Models\Individual;
use Bishopm\Connexion\Models\Group;
use Bishopm\Connexion\Repositories\SettingsRepository;

class SongsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $setting;

    public function __construct(SettingsRepository $setting)
    {
        $this->setting = $setting;
    }

    public function index(Request $request)
    {
        $songs = Song::whereIn('musictype',$request->musictype)->where(function($query) use ($request){
            $query->where('title','like','%' . $request->search . '%');
            $query->orWhere('words','like','%' . $request->search . '%');
            $query->orWhere('author','like','%' . $request->search . '%');
        })->orderBy('title')->get();
        return $songs;
    }

    public function show($id)
    {
        $song = Song::find($id);
        $newlyrics = str_replace("[","<span data-chord='",$song->lyrics);
        $newlyrics = str_replace("{","<span data-heading='",$newlyrics);
        $newlyrics = str_replace("}","'> </span>",$newlyrics);
        $newlyrics = str_replace("}","'> </span>",$newlyrics);
        $i=0;
        do {
            if (substr($newlyrics, $i, 1)==']'){
                $newlyrics = substr_replace($newlyrics,"'>" . substr($newlyrics, $i+1, 1) . "</span>", $i, 2);
                $i++;
            } else {
                $i++;
            }
        } while ($i < strlen($newlyrics));
        $newlyrics = str_replace(array("\r\n", "\r", "\n"), "<br>", $newlyrics);
        $newlyrics = str_replace("<br><br>","<br>",$newlyrics);
        $song->music=$newlyrics;
        $history=Setitem::with('set')->where('song_id', '=', $id)->get();
        foreach ($history as $sitem) {
            $allh[$sitem->set->servicetime][]=$sitem->set->servicedate;
        }
        foreach ($allh as $kk=>$ss){
            rsort($allh[$kk]);
        }
        $song->history = $allh;
        return $song;
    }


}
