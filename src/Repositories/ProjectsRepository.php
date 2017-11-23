<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

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
        $project->completed=array();
        $project->todo=array();
        foreach ($project->actions as $action){
            if ($action->completed){
                $project->completed[]=$action;
            } else {
                $project->todo[]=$action;
            }
        }
        return $project;
    }
}
