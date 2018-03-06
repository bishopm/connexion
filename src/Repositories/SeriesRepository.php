<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;
use Carbon\Carbon;

class SeriesRepository extends EloquentBaseRepository
{
    public function findwithsermons($id)
    {
        $series = $this->model->with('sermons.comments')->where('id', $id)->first();
        foreach ($series->sermons as $sermon) {
            foreach ($sermon->comments as $comment) {
                $author=$comment->commented->individual->firstname . " " . $comment->commented->individual->surname;
                $comment->image = "http://umc.org.za/storage/individuals/" . $comment->commented->individual_id . "/" . $comment->commented->individual->image;
            }
        }
        return $series;
    }

    public function allwithsermons()
    {
        return $this->model->has('sermons')->orderBy('created_at', 'DESC')->get();
    }
}
