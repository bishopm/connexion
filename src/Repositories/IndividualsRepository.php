<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class IndividualsRepository extends EloquentBaseRepository
{
	public function dropdown(){
    	return $this->model->orderBy('surname', 'ASC')->select('id','surname','firstname')->get();
  	}

  	public function findBySlug($slug)
    {
        return $this->model->with('sermons','blogs')->where('slug', $slug)->first();
    }

    public function getName($id)
    {
    	$indiv=$this->model->find($id);
    	return $indiv->firstname . " " . $indiv->surname;
    }
}
