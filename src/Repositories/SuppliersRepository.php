<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SuppliersRepository extends EloquentBaseRepository
{   

	public function all()
    {
        return $this->model->orderBy('supplier')->get();
    }

}
