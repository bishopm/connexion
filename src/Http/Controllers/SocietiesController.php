<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SocietiesRepository;
use Bishopm\Connexion\Repositories\SocietiesMcsaRepository;
use Bishopm\Connexion\Models\Society;
use Bishopm\Connexion\Models\Setting;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSocietyRequest;
use Bishopm\Connexion\Http\Requests\UpdateSocietyRequest;

class SocietiesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct()
    {
        $this->structure = Setting::where('setting_key','church_structure')->first()->setting_value;
        if ($this->structure=="independent"){
            $this->society = New SocietiesRepository();
        } else {
            $this->society = New SocietiesMcsaRepository(Setting::where('setting_key','church_api_url')->first()->setting_value);
        }
    }

	public function index()
	{
        $societies = $this->society->all();
   		return view('connexion::societies.index',compact('societies'));
	}

	public function edit(Society $society)
    {
        return view('connexion::societies.edit', compact('society'));
    }

    public function create()
    {
        return view('connexion::societies.create');
    }

	public function show($society)
	{
        $data['society']=$this->society->find($society);
        return view('connexion::societies.show',$data);
	}

    public function store(CreateSocietyRequest $request)
    {
        $soc=$this->society->create($request->all());

        return redirect()->route('admin.societies.show',$soc->id)
            ->withSuccess('New society added');
    }
	
    public function update(Society $society, UpdateSocietyRequest $request)
    {
        $this->society->update($society, $request->all());
        return redirect()->route('admin.societies.index')->withSuccess('Society has been updated');
    }

    public function destroy(Society $society)
    {
        $this->society->destroy($society);
        return view('connexion::societies.index')->withSuccess('The ' . $society->society . ' society has been deleted');
    }

}