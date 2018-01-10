<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SlideshowsRepository extends EloquentBaseRepository
{
    public function byName($slideshow)
    {
        return $this->model->with(
            array(
                'slides' => function ($q) {
                    $q->where('active', '=', 1);
                }
            )
        )
        ->where('slideshow', $slideshow)->first();
    }
}
