<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model, Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;
use Plank\Mediable\Mediable;
use Actuallymab\LaravelComment\Commentable;

class Blog extends Model implements TaggableInterface
{
    use Sluggable;
    use Mediable;
    use TaggableTrait;
    use Commentable;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');
    protected $mustBeApproved = false;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['firstname', 'surname']
            ]
        ];
    }

    public function individual(){
        return $this->belongsTo('Bishopm\Connexion\Models\Individual');
    }

}
