<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class EmployeesRepository extends EloquentBaseRepository
{
    public function update($id, $data)
    {
        $employee=$this->model->find($id);
        $employee->update($data);
        return $employee;
    }
}
