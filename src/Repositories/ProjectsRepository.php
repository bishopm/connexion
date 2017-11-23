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

    public function findForApi($indiv){
        return $this->model->with('actions','individual')->where('individual_id',$indiv)->first();
    }
}
