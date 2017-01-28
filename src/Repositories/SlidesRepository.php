<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SlidesRepository extends EloquentBaseRepository
{
	public function getSlideshow($slideshowname){
        return $this->model->where('slideshowname',$slideshowname)->orderBy('rankorder', 'ASC')->get();
    }
}
