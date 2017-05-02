<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class StatisticsRepository extends EloquentBaseRepository
{
	public function allForService($service)
    {
        return $this->model->where('service_id',$service)->orderBy('statdate', 'DESC')->get();
    }
}
