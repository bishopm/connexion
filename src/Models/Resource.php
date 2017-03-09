<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;
use Actuallymab\LaravelComment\Commentable;

class Resource extends Model
{
    use Mediable;
    use Commentable;
    
    protected $guarded = array('id');
    protected $canBeRated = true;
    protected $mustBeApproved = false;

    public function ratings(){
        return $this->hasMany('Bishopm\Connexion\Models\Rating');
    }
}
