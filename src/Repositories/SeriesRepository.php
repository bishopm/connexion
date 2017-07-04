<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SeriesRepository extends EloquentBaseRepository
{
    public function findwithsermons($id)
    {
        return $series=$this->model->with('sermons')->where('id',$id)->first();
    }


	public function allwithsermons()
    {
        return $this->model->has('sermons')->get();
    }
}
