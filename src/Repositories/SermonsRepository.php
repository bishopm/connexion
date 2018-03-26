<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SermonsRepository extends EloquentBaseRepository
{
    public function mostRecent()
    {
        return $this->model->with('series', 'individual', 'comments')->where('status', 'Published')->orderBy('servicedate', 'DESC')->first();
    }
    
    public function forApi($id)
    {
        return $this->model->with('series', 'individual', 'comments')->where('id', $id)->first();
    }

    public function findBySeriesAndSlug($series, $slug)
    {
        return $this->model->where('series_id', $series)->where('slug', $slug)->first();
    }
}
