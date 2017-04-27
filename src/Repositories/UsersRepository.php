<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class UsersRepository extends EloquentBaseRepository
{
	public function getidbytoodledo($toodledo_id){
        return $this->model->where('toodledo_id','=',$toodledo_id)->get();
    }

	public function getuserbyindiv($individual_id){
        return $this->model->where('individual_id','=',$individual_id)->with('comments')->first();
    }

    public function mostRecent($num=1)
    {
        return $this->model->with('individual')->orderBy('created_at', 'DESC')->get()->take($num);
    }

    public function inactive()
    {
        return $this->model->with('individual')->onlyTrashed()->orderBy('name', 'DESC')->get();
    }

    public function activate($id)
    {
        $user=$this->model->withTrashed()->where('id',$id)->first();
        $user->restore();
        return $user;
    }

}