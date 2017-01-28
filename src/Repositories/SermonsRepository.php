<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SermonsRepository extends EloquentBaseRepository
{
	public function mostRecent()
    {
        return $this->model->with('series','individual')->orderBy('servicedate', 'DESC')->first();
    }
}
