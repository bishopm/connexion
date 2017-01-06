<?php namespace bishopm\base\Repositories;

use bishopm\base\Repositories\EloquentBaseRepository;

class UsersRepository extends EloquentBaseRepository
{
	public function getidbytoodledo($toodledo_id){
        return $this->model->where('toodledo_id'=>$toodledo_id)->get();
    }
}