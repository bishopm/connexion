<?php namespace bishopm\base\Repositories;

use bishopm\base\Repositories\EloquentBaseRepository;

class PermissionsRepository extends EloquentBaseRepository
{
	public function all()
    {
        return $this->model->orderBy('name')->get();
    }
}