<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\ProjectsRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Auth;
use Bishopm\Connexion\Models\Project;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateProjectRequest;
use Bishopm\Connexion\Http\Requests\UpdateProjectRequest;

class ProjectsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $project, $individuals, $user;

	public function __construct(ProjectsRepository $project, IndividualsRepository $individuals)
    {
        $this->project = $project;
        $this->individuals = $individuals;
    }

	public function index()
	{
        $projects = $this->project->all();
   		return view('connexion::projects.index',compact('projects'));
	}

	public function edit(Project $project)
    {
        $data['project'] = $project;
        $data['individuals'] = $this->individuals->all();
        return view('connexion::projects.edit', $data);
    }

    public function create()
    {
        $data['individuals'] = $this->individuals->all();
        return view('connexion::projects.create',$data);
    }

	public function show(Project $project)
	{
        $data['project']=$project;
        return view('connexion::projects.show',$data);
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

    public function api_projects($indiv)
    {
        return $this->project->allForApi($indiv);
    }

    public function api_project($id)
    {
        return $this->project->find($id);
    }


}