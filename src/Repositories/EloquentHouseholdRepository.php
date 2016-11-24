<?php namespace bishopm\base\Repositories;

use bishopm\base\Repositories\HouseholdRepository;
use bishopm\base\Repositories\EloquentBaseRepository;

class EloquentHouseholdRepository extends EloquentBaseRepository implements HouseholdRepository
{
    public function all()
    {
        return $this->model->orderBy('sortsurname', 'ASC')->get();
    }

    public function find($id)
    {
        return $this->model->with('individual.groups','pastoral','specialday')->find($id);
    }
}
