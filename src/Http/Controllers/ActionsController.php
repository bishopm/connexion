<?php

namespace Bishopm\Connexion\Http\Controllers;

use Auth;
use JWTAuth;
use Bishopm\Connexion\Models\Action;
use Bishopm\Connexion\Repositories\ActionsRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\ProjectsRepository;
use Bishopm\Connexion\Repositories\FoldersRepository;
use Bishopm\Connexion\Http\Requests\CreateActionRequest;
use Bishopm\Connexion\Http\Requests\UpdateActionRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class ActionsController extends Controller
{
    /**
     * @var ActionRepository
     */
    private $action;
    private $individuals;
    private $projects;
    private $folders;

    public function __construct(ActionsRepository $action, IndividualsRepository $individuals, ProjectsRepository $projects, FoldersRepository $folders)
    {
        $this->action = $action;
        $this->individuals = $individuals;
        $this->projects = $projects;
        $this->folders = $folders;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['actions'] = $this->action->all();
        return view('connexion::actions.index', $data);
    }

    public function taskapi()
    {
        $user = JWTAuth::parseToken()->toUser();
        $tasks=$this->action->individualtasks($user->individual_id);
        if (count($tasks)) {
            foreach ($tasks as $task) {
                $task->project=$task->project->description;
                $task->folder=$task->folder->folder;
                $task->individual=$task->individual->firstname . " " . $task->individual->surname;
            };
        }
        return $tasks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        $project=$this->projects->find($id);
        $folders=$this->folders->dropdown();
        $tags=Action::allTags()->get();
        return view('connexion::actions.create', compact('folders', 'tags', 'project'));
    }

    public function generalcreate()
    {
        $projects=$this->projects->all();
        $individuals=$this->individuals->all();
        $folders=$this->folders->dropdown();
        $tags=Action::allTags()->get();
        return view('connexion::actions.gencreate', compact('folders', 'tags', 'projects','individuals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store($project, CreateActionRequest $request)
    {
        $action=$this->action->create($request->except('context'));
        $action->tag($request->context);
        return redirect()->route('admin.projects.show', $project)
            ->withSuccess('Task has been created', ['name' => 'Tasks']);
    }

    public function generalstore(CreateActionRequest $request)
    {
        $action=$this->action->create($request->except('context'));
        $action->tag($request->context);
        return redirect()->route('admin.projects.show', $action->project_id)
            ->withSuccess('Task has been created', ['name' => 'Tasks']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Action $action
     * @return Response
     */
    public function edit(Action $action)
    {
        $folders=$this->folders->dropdown();
        $project=$this->projects->find($action->project_id);
        $tags=Action::allTags()->get();
        $atags=array();
        foreach ($action->tags as $tag) {
            $atags[]=$tag->name;
        }
        return view('connexion::actions.edit', compact('action', 'project', 'folders', 'tags', 'atags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Action $action
     * @param  Request $request
     * @return Response
     */
    public function update(Action $action, UpdateActionRequest $request)
    {
        $this->action->update($action, $request->except('context'));
        $action->tag($request->context);
        return redirect()->route('admin.projects.show', $action->project_id)
            ->withSuccess('Task has been updated', ['name' => 'Task']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Action $action
     * @return Response
     */
    public function destroy(Action $action)
    {
        $this->action->destroy($action);

        return redirect()->route('admin.actions.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('todo::actions.title.actions')]));
    }

    public function addtag($action, $tag)
    {
        $task=Action::find($action);
        $task->tag($tag);
    }

    public function removetag($action, $tag)
    {
        $task=Action::find($action);
        $task->untag($tag);
    }

    public function togglecompleted($id)
    {
        $task=Action::find($id);
        if (count($task)) {
            $task->completed=time();
            $task->save();
            return "success!";
        } else {
            return "Task not found";
        }
    }

    public function api_projectindivs()
    {
        return $this->action->projectindivs();
    }

    public function api_newtask(Request $request)
    {
        return $this->action->create($request->all());
    }
}
