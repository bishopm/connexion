<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class FoldersRepository extends EloquentBaseRepository
{   
	public function dropdown(){
        return $this->model->orderBy('id', 'ASC')->select('id','folder')->get();
    }
}
