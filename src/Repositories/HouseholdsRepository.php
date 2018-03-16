<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class HouseholdsRepository extends EloquentBaseRepository
{
    public function all()
    {
        return $this->model->orderBy('sortsurname', 'ASC')->get();
    }

    public function dropdown()
    {
        $data = array();
        $households = $this->model->orderBy('sortsurname', 'ASC')->select('addressee', 'id')->get();
        foreach ($households as $household) {
            $data[$household->id]=$household->addressee;
        }
        return $data;
    }

    public function find($id)
    {
        return $this->model->with('individuals')->find($id);
    }

    public function findForApi($id)
    {
        return $this->model->with('individuals', 'individuals.user')->find($id);
    }
}
