<?php namespace bishopm\base\Repositories;

use bishopm\base\Repositories\EloquentBaseRepository;

class GroupsRepository extends EloquentBaseRepository
{
    public function all()
    {
        return $this->model->orderBy('groupname', 'ASC')->get();
    }

	public function find($id)
    {
        return $this->model->with('individuals')->find($id);
    }
}
