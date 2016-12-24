<?php namespace bishopm\base\Repositories;

use bishopm\base\Repositories\EloquentBaseRepository;

class BlogsRepository extends EloquentBaseRepository
{   
	public function mostRecent($num=1)
    {
        return $this->model->with('individual')->orderBy('created_at', 'DESC')->get()->take($num);
    }
}
