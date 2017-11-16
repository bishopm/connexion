<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SeriesRepository extends EloquentBaseRepository
{
    public function findwithsermons($id)
    {
        return $this->model->with('sermons.comments')->where('id',$id)->first();
    }


	public function allwithsermons()
    {
        return $this->model->has('sermons')->get();
    }
}
