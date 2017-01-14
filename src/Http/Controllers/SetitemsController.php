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
