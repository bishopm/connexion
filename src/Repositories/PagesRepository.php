<?php namespace bishopm\base\Repositories;

use bishopm\base\Repositories\EloquentBaseRepository;

class PagesRepository extends EloquentBaseRepository
{
	public function all()
    {
        return $this->model->orderBy('title')->get();
    }
}
