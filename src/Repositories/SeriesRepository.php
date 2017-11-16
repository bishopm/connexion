<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;
use Carbon\Carbon;

class SeriesRepository extends EloquentBaseRepository
{
    public function findwithsermons($id)
    {
        $series = $this->model->with('sermons.comments.users.individuals')->where('id',$id)->first();
        foreach ($series->sermons as $sermon){
            foreach ($sermon->comments as $comment){
                $author=$comment->user->individual->firstname . " " . $comment->user->individual->surname;
                $comment->image = "http://umc.org.za/storage/individuals/" . $comment->user->individual_id . "/" . $comment->user->individual->image;
            }
        }
        return $series;
    }


	public function allwithsermons()
    {
        return $this->model->has('sermons')->get();
    }
}
