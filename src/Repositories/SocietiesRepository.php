<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SocietiesRepository extends EloquentBaseRepository
{
	public function find($id)
    {
        return $this->model->with('services')->find($id);
    }
}
