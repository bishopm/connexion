<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SocietiesRepository;
use Bishopm\Connexion\Models\Society;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSocietyRequest;
use Bishopm\Connexion\Http\Requests\UpdateSocietyRequest;

class SocietiesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $society;

	public function __construct(SocietiesRepository $society)
    {
        $this->society = $society;
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

	public function show(Society $society)
	{
        $data['society']=$society;
        return view('connexion::societies.show',$data);
	}

    public function store(CreateSocietyRequest $request)
    {
        $this->society->create($request->all());

        return redirect()->route('admin.societies.index')
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