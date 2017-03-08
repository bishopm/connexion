<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;
use Actuallymab\LaravelComment\Commentable;

class Sermon extends Model implements TaggableInterface
{

    use TaggableTrait;
    use Commentable;

    protected $guarded = array('id');


    public function series(){
        return $this->belongsTo('Bishopm\Connexion\Models\Series');
    }
    
    public function individual(){
        return $this->belongsTo('Bishopm\Connexion\Models\Individual');
    }
}
