<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class PagesRepository extends EloquentBaseRepository
{
	public function all()
    {
        return $this->model->orderBy('title')->get();
    }
}
