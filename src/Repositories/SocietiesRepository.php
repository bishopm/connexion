<?php namespace bishopm\base\Repositories;

use bishopm\base\Repositories\EloquentBaseRepository;

class SocietiesRepository extends EloquentBaseRepository
{
	public function find($id)
    {
        return $this->model->with('services')->find($id);
    }
}
