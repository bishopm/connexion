<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class HouseholdsRepository extends EloquentBaseRepository
{
    public function all()
    {
        return $this->model->orderBy('sortsurname', 'ASC')->get();
    }

	public function find($id)
    {
        return $this->model->with('individuals')->find($id);
    }
}
