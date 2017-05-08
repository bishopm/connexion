<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SeriesRepository extends EloquentBaseRepository
{
	public function allwithsermons()
    {
        return $this->model->has('sermons')->get();
    }
}
