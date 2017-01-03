<?php namespace bishopm\base\Repositories;

use bishopm\base\Repositories\EloquentBaseRepository;

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
}
