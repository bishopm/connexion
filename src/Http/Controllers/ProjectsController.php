<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\ProjectsRepository;
use bishopm\base\Repositories\IndividualsRepository;
use bishopm\base\Models\Project;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateProjectRequest;
use bishopm\base\Http\Requests\UpdateProjectRequest;

class ProjectsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $project, $individuals;

	public function __construct(ProjectsRepository $project, IndividualsRepository $individuals)
    {
        $this->project = $project;
        $this->individuals = $individuals;
    }

	public function index()
	{
        $projects = $this->project->all();
   		return view('base::projects.index',compact('projects'));
	}

	public function edit(Project $project)
    {
        $data['project'] = $project;
        $data['individuals'] = $this->individuals->all();
        return view('base::projects.edit', $data);
    }

    public function create()
    {
        $data['individuals'] = $this->individuals->all();
        return view('base::projects.create',$data);
    }

	public function show(Project $project)
	{
        $data['project']=$project;
        return view('base::projects.show',$data);
	}

    public function store(CreateProjectRequest $request)
    {
        $this->project->create($request->all());

        return redirect()->route('admin.projects.index')
            ->withSuccess('New project added');
    }
	
    public function update(Project $project, UpdateProjectRequest $request)
    {
        $this->project->update($project, $request->all());
        return redirect()->route('admin.projects.index')->withSuccess('Project has been updated');
    }

}