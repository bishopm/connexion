<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SermonsRepository extends EloquentBaseRepository
{
	public function mostRecent()
    {
        return $this->model->with('series','individual','comments')->first();
    }
    
    public function forApi($id)
    {
        return $this->model->with('series','individual','comments')->where('id',$id)->first();
    }
}
