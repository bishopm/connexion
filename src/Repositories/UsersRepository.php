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

    public function findWithContent($id)
    {
        return $this->model->with('individual.groups','individual.sermons','individual.blogs')->find($id);
    }

    public function findForApi($id)
    {
        $user = $this->model->with('individual.groups','individual.sermons','individual.blogs')->find($id);
        $user->groups=$user->individual->groups()->sortBy('groups.groupname')->get();
        $user->sermons=$user->individual->sermons()->sortByDesc('sermons.servicedate')->get();
        foreach ($user->sermons as $sermon){
            $sermon->sdate = date("j M Y",strtotime($sermon->created_at));
        }
        $user->blogs=$user->individual->blogs()->sortByDesc('created_at')->get();
        foreach ($user->blogs as $blog){
            $blog->bdate = date("j M Y",strtotime($blog->created_at));
        }
        return $user;
    }

    public function activate($id)
    {
        $user=$this->model->withTrashed()->where('id',$id)->first();
        $user->restore();
        return $user;
    }

    public function allVerified()
    {
        return $this->model
            ->where('verified',1)
            ->join('individuals', 'individuals.id', '=', 'users.individual_id')
            ->orderBy('individuals.surname')->select('individuals.*','users.*','users.id as userid')
            ->get();
    }

}