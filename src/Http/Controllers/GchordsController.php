<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request, Log, DB, App\Libraries\Chord;
use App\Http\Requests, View, App\Http\Requests\GchordsRequest;
use App\Http\Controllers\Controller, Helpers, App\Models\Gchord;

class GchordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $chords=Gchord::orderBy('chordname')->get();
        if (count($chords)){
            foreach ($chords as $chord){
                if (substr($chord->chordname,1,1)=="#") {
                    $key=substr($chord->chordname,0,2);
                } elseif (substr($chord->chordname,1,1)=="b") {
                    $key=substr($chord->chordname,0,2);
                } else {
                    $key=substr($chord->chordname,0,1);
                }
                $data['chords'][$key][]=$chord->id;
            }
            return view('chords.index',$data);
        } else {
            return view('chords.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($name='')
    {
        if (Helpers::perm('edit')){
            $data['chordname']=$name;
            return view('chords.create',$data);
        } else {
            return view('shared.unauthorised');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(GchordsRequest $request)
    {
        $chord=Gchord::create($request->all());
        $c = new chord(array($request->fingering[0],$request->fingering[1],$request->fingering[2],$request->fingering[3],$request->fingering[4],$request->fingering[5]));
        $highest=0;
        $c->setTitle($request->chordname);
        if ($request->barre<>""){
            $allf=str_split($request->fingering);
            foreach ($allf as $tf){
                if (intval($tf)>$highest){
                    $highest=intval($tf);
                }
            }
            if ($highest>4){
                $c->setStartingFret($highest-3);
            }
            $c->setShowZeros(false);
            $c->setShowUnstrummedStrings(false);
            $c->setBarreChord($request->barre[0],$request->barre[1],$request->barre[2]);
        }
        $c->draw($chord->id);
        return redirect('chords/' . $chord->id . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data['chord']=Gchord::find($id);
        return view('chords.edit',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        if (Helpers::perm('edit')){
            $data['chord']=Gchord::find($id);
            return view('chords.edit',$data);
        } else {
            return view('shared.unauthorised');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function update($id, GchordsRequest $request)
    {
        $chord=Gchord::find($id);
        $chord->fill($request->all());
        $c = new chord(array($request->fingering[0],$request->fingering[1],$request->fingering[2],$request->fingering[3],$request->fingering[4],$request->fingering[5]));
        $c->setTitle($request->chordname);
        if ($request->barre<>""){
            $c->setShowZeros(false);
            $c->setShowUnstrummedStrings(false);
            $c->setBarreChord($request->barre[0],$request->barre[1],$request->barre[2]);
        }
        $c->draw($chord->id);
        $chord->save();
        $data['chord']=$chord;
        return view('chords.edit',$data);
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

}
