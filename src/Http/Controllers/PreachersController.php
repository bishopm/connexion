<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\PreachersRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\SocietiesRepository;
use Bishopm\Connexion\Models\Preacher;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreatePreacherRequest;
use Bishopm\Connexion\Http\Requests\UpdatePreacherRequest;

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
        if (gettype($preachers)=="string"){
            return redirect()->route('admin.settings.index')->with('notice','Please ensure that the API url is correctly specified');
        } else {
            return view('connexion::preachers.index',compact('preachers'));
        }
	}

	public function edit(Preacher $preacher)
    {
        $data['individuals'] = $this->individuals->all();
        $data['societies'] = $this->societies->all();
        $data['preacher'] = $preacher;
        return view('connexion::preachers.edit', $data);
    }

    public function create()
    {
        $data['individuals'] = $this->individuals->all();
        $data['societies'] = $this->societies->all();
        if (count($data['societies'])){
            return view('connexion::preachers.create',$data);
        } else {
            return redirect()->route('admin.societies.create')->with('notice','At least one society must be added before adding a preacher');
        }
    }

	public function show(Preacher $preacher)
	{
        $data['preacher']=$preacher;
        return view('connexion::preachers.show',$data);
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