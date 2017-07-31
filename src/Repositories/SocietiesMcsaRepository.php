<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\McsaRepository;

class SocietiesMCSARepository extends McsaBaseRepository
{
	public function find($id)
    {
        return $this->model->with('services')->find($id);
    }

    public function dropdown(){
        return $this->model->orderBy('society', 'ASC')->select('id','society')->get();
    }
}
