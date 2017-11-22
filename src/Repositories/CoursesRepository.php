<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class CoursesRepository extends EloquentBaseRepository
{
	public function getcourses($coursetype){
        return $this->model->where('category',$coursetype)->get();
    }

    public function allForApi(){
        return $this->model->orderBy('title')->get();
    }
}
