<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\PersonsRepository;
use bishopm\base\Models\Person;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreatePersonRequest;
use bishopm\base\Http\Requests\UpdatePersonRequest;

class PersonsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $person;

	public function __construct(PersonsRepository $person)
    {
        $this->person = $person;
    }

	public function index()
	{
        $persons = $this->person->all();
   		return view('base::persons.index',compact('persons'));
	}

	public function edit(Person $person)
    {
        return view('base::persons.edit', compact('person'));
    }

    public function create()
    {
        return view('base::persons.create');
    }

	public function show(Person $person)
	{
        $data['person']=$person;
        return view('base::persons.show',$data);
	}

    public function store(CreatePersonRequest $request)
    {
        $this->person->create($request->all());

        return redirect()->route('admin.persons.index')
            ->withSuccess('New person added');
    }
	
    public function update(Person $person, UpdatePersonRequest $request)
    {
        $this->person->update($person, $request->all());
        return redirect()->route('admin.persons.index')->withSuccess('Person has been updated');
    }

}