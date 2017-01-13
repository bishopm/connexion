<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request, Log, DB;
use App\Http\Requests, View, App\Http\Requests\SetsRequest;
use App\Http\Controllers\Controller, Helpers, App\Models\Song, App\Models\Setitem, App\Models\Set, App\Models\Service;

class SetitemsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(Request $request)
    {
        $setitem=Setitem::create($request->all());
        return $setitem;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Setitem::find($id)->delete();
    }

}
