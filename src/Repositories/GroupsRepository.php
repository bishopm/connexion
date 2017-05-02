<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class GroupsRepository extends EloquentBaseRepository
{
    public function all()
    {
        return $this->model->orderBy('groupname', 'ASC')->get();
    }

    public function allPublished()
    {
        return $this->model->where('publish',1)->orderBy('groupname', 'ASC')->get();
    }

	public function find($id)
    {
        return $this->model->with('individuals')->find($id);
    }

    public function findByName($name)
    {
        return $this->model->with('individuals')->where('groupname',$name)->first();
    }

    public function dropdown(){
        return $this->model->orderBy('groupname', 'ASC')->select('id','groupname')->get();
    }
}
