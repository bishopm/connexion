<?php namespace bishopm\base\Repositories;

use bishopm\base\Repositories\EloquentBaseRepository;

class IndividualsRepository extends EloquentBaseRepository
{
	public function dropdown(){
    	return $this->model->orderBy('surname', 'ASC')->select('id','surname','firstname')->get();
  	}
}
