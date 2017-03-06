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

    public function forEmail($email)
    {
        $hhh=$this->model->where('email', $email)->select('household_id')->first();
        if ($hhh){
            $household=$hhh->household_id;
            return $this->model->where('household_id', $household)->select('id','surname','firstname')->get()->toJson();   
        } else {
            return "No data";
        }
    }
}
