<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class PostsRepository extends EloquentBaseRepository
{   
	public function alltitles()
    {
        return $this->model->whereNull('thread')->orderBy('created_at')->get();
    }

    public function countreplies($id)
    {
        return $this->model->where('thread',$id)->orderBy('created_at')->count();
    }

    public function getreplies($id)
    {
        return $this->model->where('thread',$id)->orderBy('created_at')->get();
    }
}
