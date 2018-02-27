<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class BlocksRepository extends EloquentBaseRepository
{
    public function homepage()
    {
        return $this->model->orderBy('column', 'ASC')->orderBy('order', 'ASC')->where('active', '=', 1)->get();
    }
}
