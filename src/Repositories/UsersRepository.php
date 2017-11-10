<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class UsersRepository extends EloquentBaseRepository
{

	public function getuserbyindiv($individual_id){
        return $this->model->where('individual_id','=',$individual_id)->with('comments')->first();
    }

    public function mostRecent($num=1)
    {
        return $this->model->with('individual')->where('verified',1)->orderBy('created_at', 'DESC')->get()->take($num);
    }

    public function inactive()
    {
        return $this->model->with('individual')->onlyTrashed()->orderBy('name', 'DESC')->get();
    }

    public function find($id)
    {
        return $this->model->with('individual.groups')->find($id);
    }

    public function activate($id)
    {
        $user=$this->model->withTrashed()->where('id',$id)->first();
        $user->restore();
        return $user;
    }

    public function allVerified()
    {
        return $this->model->where('verified',1)->orderBy('name')->get();
    }

}