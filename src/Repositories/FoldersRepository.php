<?php namespace bishopm\base\Repositories;

use bishopm\base\Repositories\EloquentBaseRepository;

class FoldersRepository extends EloquentBaseRepository
{   
	public function dropdown(){
        return $this->model->orderBy('id', 'ASC')->select('id','folder')->get();
    }
}
