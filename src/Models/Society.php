<?php

namespace Bishopm\Connexion\Models;

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
        return $this->hasMany('Bishopm\Connexion\Models\Service');
    }

}
