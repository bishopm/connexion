<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;
use Carbon\Carbon;

class MessagesRepository extends EloquentBaseRepository
{
    public function userMessages($id)
    {
        $messages = $this->model->where('receiver_id','=',$id)->orderBy('created_at')->get();
        foreach ($messages as $message){
            $message->sender = $message->user->individual->firstname . " " . $message->user->individual->surname;
            $message->senderpic = url('/') . "/storage/individuals/" . $message->user->individual_id . "/" . $message->user->individual->image;
            $message->ago = Carbon::parse($message->created_at)->diffForHumans();
        }
        return $messages;
    }

}
