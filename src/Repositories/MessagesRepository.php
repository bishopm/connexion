<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;
use Carbon\Carbon;
use Bishopm\Connexion\Models\Message;

class MessagesRepository extends EloquentBaseRepository
{
    public function thread($user,$id)
    {
        $messages = $this->model->with('user.individual')
        ->where(function ($query) use ($user,$id)
        {
            $query->where('receiver_id', $id)
                  ->where('user_id', $user);
        })
        ->orWhere(function($query) use ($user,$id)
        {
            $query->where('receiver_id', $user)
                  ->where('user_id', $id);
        })->orderBy('created_at','DESC')->get();
        foreach ($messages as $message) {
            $message->sender = $message->user->individual->firstname . " " . $message->user->individual->surname;
            $message->senderpic = url('/') . "/storage/individuals/" . $message->user->individual_id . "/" . $message->user->individual->image;
            $message->viewed = 1;
            $message->ago = Carbon::parse($message->created_at)->diffForHumans();
            $markasviewed = Message::find($message->id);
            $markasviewed->viewed=1;
            $markasviewed->save();
        }
        return $messages;
    }

}
