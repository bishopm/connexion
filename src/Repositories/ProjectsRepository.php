<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;
use Carbon\Carbon

class ProjectsRepository extends EloquentBaseRepository
{
	public function dropdown(){
        return $this->model->orderBy('description', 'ASC')->select('id','description')->get();
    }

    public function getidbydescription($description){
        $ff=array('description'=>$description);
        return $this->model->firstorCreate($ff);
    }

    public function findbyuid($uid){
        return $this->model->where('user_id','=',$uid)->get();
    }

    public function allForApi($indiv){
        return $this->model->where('individual_id',$indiv)->OrderBy('description')->get();
    }

    public function findForApi($id){
        $project = $this->model->with('actions','actions.individual')->where('id',$id)->first();
        $completed=array();
        $todo=array();
        foreach ($project->actions as $action){
            if ($action->completed){
                $action->ago=Carbon::parse($action->completed)->diffForHumans();
                $completed[]=$action;
            } else {
                $todo[]=$action;
            }
        }
        $project->completed=$completed;
        $project->todo=$todo;
        return $project;
    }
}
