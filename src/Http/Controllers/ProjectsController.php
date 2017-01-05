<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\ProjectsRepository;
use bishopm\base\Repositories\IndividualsRepository;
use Auth;
use bishopm\base\Models\Project;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateProjectRequest;
use bishopm\base\Http\Requests\UpdateProjectRequest;
use bishopm\base\Http\Controllers\Toodledo;

class ProjectsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $project, $individuals, $toodledo, $user;

	public function __construct(ProjectsRepository $project, IndividualsRepository $individuals, Toodledo $toodledo)
    {
        $this->project = $project;
        $this->individuals = $individuals;
        $this->toodledo = new Toodledo();
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
        $user=Auth::user();
        $this->project->create($request->all());

        return redirect()->route('admin.projects.index')
            ->withSuccess('New project added');
    }
	
    public function update(Project $project, UpdateProjectRequest $request)
    {
        $user=Auth::user();
        if ($project->description <> $request->description){
            $tasks=$this->toodledo->getData($user,'tasks','initial');
            foreach ($tasks as $task){
                if ((property_exists($task, 'tag')) and ($task->tag==$project->description)){
                    $dum['id']=$task->id;
                    $dum['tag']=$request->description;
                    $etasks[]=$dum;
                }
            }
        }
        $editedtasks=str_replace(':', '%3A', json_encode($etasks));
        $editedtasks=str_replace(',', '%2C', $editedtasks);
        $data['access_token']=$user->toodledo_token;
        $data['tasks']=$editedtasks;
        $data['fields']="tag";
        $resp=$this->toodledo->updateData($user,'tasks',$data);
        dd($resp);
        $this->project->update($project, $request->all());
        return redirect()->route('admin.projects.index')->withSuccess('Project has been updated');
    }

}