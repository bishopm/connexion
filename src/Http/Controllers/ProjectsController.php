<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\ProjectsRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Auth;
use Bishopm\Connexion\Models\Project;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateProjectRequest;
use Bishopm\Connexion\Http\Requests\UpdateProjectRequest;
use Bishopm\Connexion\Http\Controllers\Toodledo;

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
        $user=Auth::user();
        $this->project->create($request->all());

        return redirect()->route('admin.projects.index')
            ->withSuccess('New project added');
    }
	
    public function update(Project $project, UpdateProjectRequest $request)
    {
        $user=Auth::user();
        if (($user->toodledo_token) and ($project->description <> $request->description)){
            $tasks=$this->toodledo->getData($user,'tasks','initial');
            $etasks=array();
            foreach ($tasks as $task){
                if ((property_exists($task, 'tag')) and ($task->tag==$project->description)){
                    $dum['id']=$task->id;
                    $dum['tag']=$request->description;
                    $etasks[]=$dum;
                } 
            }
            if (count($etasks)){
                $data="tasks=" . str_replace(':', '%3A', json_encode($etasks));
                $data=str_replace(',', '%2C', $data);
                $data.="&access_token=" . $user->toodledo_token;
                $data.="&fields=tag";
                $resp=$this->toodledo->updateData($user,'tasks',$data);
            }
        }
        $this->project->update($project, $request->all());
        return redirect()->route('admin.projects.index')->withSuccess('Project has been updated');
    }

}