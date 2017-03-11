<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class ResourcesRepository extends EloquentBaseRepository
{
	public function getcourses($coursetype){
        return $this->model->where('category',$coursetype)->get();
    }
}
