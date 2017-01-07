<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\SocietiesRepository;
use bishopm\base\Models\Society;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateSocietyRequest;
use bishopm\base\Http\Requests\UpdateSocietyRequest;

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
   		return view('base::societies.index',compact('societies'));
	}

	public function edit(Society $society)
    {
        return view('base::societies.edit', compact('society'));
    }

    public function create()
    {
        return view('base::societies.create');
    }

	public function show(Society $society)
	{
        $data['society']=$society;
        return view('base::societies.show',$data);
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

}