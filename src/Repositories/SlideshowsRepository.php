<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SlideshowsRepository extends EloquentBaseRepository
{
	public function byName($slideshow)
    {
        return $this->model->with('slides')->where('slideshow',$slideshow)->first();
    }
}
