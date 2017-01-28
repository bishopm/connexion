<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class PermissionsRepository extends EloquentBaseRepository
{
	public function all()
    {
        return $this->model->orderBy('name')->get();
    }
}