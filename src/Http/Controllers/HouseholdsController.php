<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\HouseholdsRepository;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateHouseholdRequest;
use bishopm\base\Http\Requests\UpdateHouseholdRequest;

class HouseholdsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $household;

	public function __construct(HouseholdsRepository $household)
    {

        $this->household = $household;
    }

	public function index()
	{
        $households = $this->household->all();
   		return view('base::households.index',compact('households'));
	}

	public function edit(Household $household)
    {
        return view('base::households.edit', compact('household'));
    }

    public function create()
    {
        return view('base::households.create');
    }

	public function show($household)
	{
		return "Display household";
	}

    public function store(CreateHouseholdRequest $request)
    {
        $this->household->create($request->all());

        return redirect()->route('admin.households.index')
            ->withSuccess('New household added');
    }
	

}
