<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class RostersRepository extends EloquentBaseRepository
{
    public function dropdown(){
        return $this->model->orderBy('rostername', 'ASC')->select('id','rostername')->get();
    }
}
