<?php namespace bishopm\base\Repositories;

use bishopm\base\Repositories\EloquentBaseRepository;

class SlidesRepository extends EloquentBaseRepository
{
	public function getSlideshow($slideshowname){
        return $this->model->where('slideshowname',$slideshowname)->orderBy('rankorder', 'ASC')->get();
    }
}
