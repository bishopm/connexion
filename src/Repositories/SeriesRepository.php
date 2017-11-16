<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SeriesRepository extends EloquentBaseRepository
{
    public function findwithsermons($id)
    {
        $series = $this->model->with('sermons.comments','sermons.individual')->where('id',$id)->first();
        foreach ($series->sermons as $sermon){
            foreach ($sermon->comments as $comment){
                $author=$this->user->find($comment->commented_id);
                $comment->author = $author->individual->firstname . " " . $author->individual->surname;
                $comment->image = "http://umc.org.za/public/storage/individuals/" . $author->individual_id . "/" . $author->individual->image;
            }
        }
        return $series;
    }


	public function allwithsermons()
    {
        return $this->model->has('sermons')->get();
    }
}
