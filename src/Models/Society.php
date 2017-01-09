<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Society extends Model
{

	use Sluggable;

    protected $guarded = array('id');

	public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['society']
            ]
        ];
    }

    public function services(){
        return $this->hasMany('bishopm\base\Models\Service');
    }

}
