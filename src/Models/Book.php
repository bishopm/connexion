<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;
use Actuallymab\LaravelComment\Commentable;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Book extends Model implements TaggableInterface
{
    use TaggableTrait;
    use Mediable;
    use Commentable;
    
    protected $guarded = array('id');
    protected $canBeRated = true;
    protected $mustBeApproved = false;

}
