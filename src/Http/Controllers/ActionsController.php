<?php

namespace bishopm\base\Http\Controllers;

use Auth;
use bishopm\base\Http\Controllers\Toodledo;
use bishopm\base\Models\Action;
use bishopm\base\Repositories\ActionsRepository;
use bishopm\base\Repositories\IndividualsRepository;
use bishopm\base\Repositories\ProjectsRepository;
use bishopm\base\Repositories\FoldersRepository;
use bishopm\base\Http\Requests\CreateActionRequest;
use bishopm\base\Http\Requests\UpdateActionRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class ActionsController extends Controller
{
    /**
     * @var ActionRepository
     */
    private $action, $individuals, $projects, $folders;

    public function __construct(ActionsRepository $action, IndividualsRepository $individuals, ProjectsRepository $projects, FoldersRepository $folders)
    {
        $this->action = $action;
        $this->individuals = $individuals;
        $this->projects = $projects;
        $this->folders = $folders;
        $this->provider = new Toodledo();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user=Auth::user();
        if ((!$user->toodledo_id) or (isset($_GET['code']))) {
            $data['authorizationUrl'] = $this->provider->getAuthorizationUrl();
            if (isset($_GET['code'])){
                $token=$this->provider->getAccessToken('authorization_code', ['code' => $_GET['code']]);
                $tokenStr=$token->getToken();
                $data2 = $this->provider->getInitial($tokenStr);
                $user->toodledo_id=$data2->userid;
                $user->toodledo_token=$tokenStr;
                $user->toodledo_refresh=$token->getRefreshToken();
                $user->save();
                Artisan::call('toodledo:sync', ['category' => 'initial']);
            }
        } else {
            $data['authorizationUrl'] = "NA";
        }
        $data['actions'] = $this->action->all();
        return view('base::actions.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $individuals=$this->individuals->dropdown();
        $folders=$this->folders->dropdown();
        $projects=$this->projects->dropdown();
        $tags=Action::allTags()->get();
        return view('base::actions.create',compact('individuals','projects','folders','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(CreateActionRequest $request)
    {
        $user=Auth::user();
        if ($user->toodledo_token){
            $contexts=$this->provider->getData($user,'contexts','initial');
            foreach ($contexts as $c){
                $tco[$c->name]=$c->id;
            }
            $task['title']=$request->description;
            $task['tag']=$this->projects->find($request->project_id)->description;
            $task['status']=$request->folder_id;
            $task['context']=$tco[$request->context];
            $data="tasks=" . str_replace(':', '%3A', json_encode($task));
            $data=str_replace(',', '%2C', $data);
            $data.="&access_token=" . $user->toodledo_token;
            $data.="&fields=tag,status,context";            
            $resp=$this->provider->addData($user,'tasks',$data);
        }
        $action=$this->action->create($request->except('context'));
        $action->tag($request->context);
        return redirect()->route('admin.actions.index')
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
        $individuals=$this->individuals->dropdown();
        $folders=$this->folders->dropdown();
        $projects=$this->projects->dropdown();
        $tags=Action::allTags()->get();
        $atags=array();
        foreach ($action->tags as $tag){
            $atags[]=$tag->name;
        }
        return view('base::actions.edit', compact('action','individuals','projects','folders','tags','atags'));
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
        $user=Auth::user();
        if ($user->toodledo_token){
            $contexts=$this->provider->getData($user,'contexts','initial');
            foreach ($contexts as $c){
                $tco[$c->name]=$c->id;
            }
            $task['id']=$action->toodledo_id;
            $task['title']=$request->description;
            $task['tag']=$this->projects->find($request->project_id)->description;
            $task['status']=$request->folder_id;
            $task['context']=$tco[$request->context];
            $data="tasks=" . str_replace(':', '%3A', json_encode($task));
            $data=str_replace(',', '%2C', $data);
            $data.="&access_token=" . $user->toodledo_token;
            $data.="&fields=tag,status,context";            
            $resp=$this->provider->updateData($user,'tasks',$data);
        }
        $this->action->update($action, $request->except('context'));

        return redirect()->route('admin.actions.index')
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

    public function togglecompleted($action){
        $user=Auth::user();
        $task=Action::find($action);
        if ($task->completed<1){
            $task->completed=time();
        } else {
            $task->completed=0;
        }
        $task->save();
        if ($user->toodledo_token){
            $t['id']=$task->toodledo_id;
            $t['completed']=$task->completed;
            $data="tasks=" . str_replace(':', '%3A', json_encode($task));
            $data=str_replace(',', '%2C', $data);
            $data.="&access_token=" . $user->toodledo_token;
            $data.="&fields=completed";
            $resp=$this->provider->updateData($user,'tasks',$data);
        }
        return "success!";
    }
}
