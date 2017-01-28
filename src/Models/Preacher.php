<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Preacher extends Model
{

	use Sluggable;

    protected $guarded = array('id');

	public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['firstname', 'surname']
            ]
        ];
    }

    public function society(){
        return $this->belongsTo('Bishopm\Connexion\Models\Society');
    }
    

}
