<?php

namespace Bishopm\Connexion\Http\Controllers;

use App\Http\Controllers\Controller, DB;
use Bishopm\Connexion\Http\Requests\CreateReadingRequest;
use Bishopm\Connexion\Http\Requests\UpdateReadingRequest;

class ReadingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $readings = DB::table('readings')->get();;
   		return view('connexion::readings.index',compact('readings'));
	}

	public function edit($reading)
    {
        $reading=DB::table('readings')->where('id','=',$reading)->first();
        return view('connexion::readings.edit', compact('reading'));
    }

    public function create()
    {
        return view('connexion::readings.create');
    }

    public function store(CreateReadingRequest $request)
    {
        $reading = DB::table('readings')->insert(['description' => $request->input('description'), 'readings' => $request->input('readings'), 'readingdate' => $request->input('readingdate')]);
        return redirect()->route('admin.readings.index')
            ->withSuccess('New reading added');
    }
	
    public function update($reading, UpdateReadingRequest $request)
    {
        $reading = DB::table('readings')->where('id', $reading)->update(['description' => $request->input('description'), 'readings' => $request->input('readings'), 'readingdate' => $request->input('readingdate')]);
        return redirect()->route('admin.readings.index')->withSuccess('Reading has been updated');
    }

    public function destroy($id)
    {
        $reading=DB::table('readings')->where('id','=',$id)->delete();
        return redirect()->route('admin.readings.index')->withSuccess('Reading has been deleted');
    }

}