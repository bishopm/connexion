<?php

namespace bishopm\base\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	use Sluggable;

    protected $guarded = array('id');

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['title']
            ]
        ];
    }
}
