<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class CommentsRepository extends EloquentBaseRepository
{   
	public function mostRecent($num=5)
    {
        return $this->model->orderBy('created_at', 'DESC')->get()->take($num);
    }
}
