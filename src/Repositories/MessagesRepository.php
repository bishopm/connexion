<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class MessagesRepository extends EloquentBaseRepository
{
    public function userMessages($id)
    {
    	return $this->model->where('receiver_id','=',$id)->orderBy('created_at')->get();
    }

}
