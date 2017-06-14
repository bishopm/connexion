<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class ActionsRepository extends EloquentBaseRepository
{
  public function all()
  {
      return $this->model->with('project')->whereNull('completed')->orWhere('completed',0)->orderBy('description')->get();
  }

  public function findbyuid($uid){
        return $this->model->where('user_id','=',$uid)->get();
  }

  public function incomplete($limit,$user){
      return $this->model->where('user_id','=',$user)->whereNull('completed')->get()->take($limit);
  }

  public function individualtasks($id){
        return $this->model->where('individual_id',$id)->where('completed',0)->get();
  }

}
