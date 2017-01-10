<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\PreachersRepository;
use bishopm\base\Repositories\IndividualsRepository;
use bishopm\base\Repositories\SocietiesRepository;
use bishopm\base\Models\Preacher;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreatePreacherRequest;
use bishopm\base\Http\Requests\UpdatePreacherRequest;

class PreachersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $preacher,$individuals, $societies;

	public function __construct(PreachersRepository $preacher, IndividualsRepository $individuals, SocietiesRepository $societies)
    {
        $this->preacher = $preacher;
        $this->individuals = $individuals;
        $this->societies = $societies;
    }

	public function index()
	{
        $preachers = $this->preacher->all();
   		return view('base::preachers.index',compact('preachers'));
	}

	public function edit(Preacher $preacher)
    {
        $data['individuals'] = $this->individuals->all();
        $data['societies'] = $this->societies->all();
        $data['preacher'] = $preacher;
        return view('base::preachers.edit', $data);
    }

    public function create()
    {
        $data['individuals'] = $this->individuals->all();
        $data['societies'] = $this->societies->all();
        if (count($data['societies'])){
            return view('base::preachers.create',$data);
        } else {
            return redirect()->route('admin.societies.create')->with('notice','At least one society must be added before adding a preacher');
        }
    }

	public function show(Preacher $preacher)
	{
        $data['preacher']=$preacher;
        return view('base::preachers.show',$data);
	}

    public function store(CreatePreacherRequest $request)
    {
        $this->preacher->create($request->except('image'));

        return redirect()->route('admin.preachers.index')
            ->withSuccess('New preacher added');
    }
	
    public function update(Preacher $preacher, UpdatePreacherRequest $request)
    {
        $this->preacher->update($preacher, $request->except('image'));
        return redirect()->route('admin.preachers.index')->withSuccess('Preacher has been updated');
    }

}