<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;
use Actuallymab\LaravelComment\Commentable;

class Course extends Model
{
    use Mediable;
    use Commentable;
    
    protected $guarded = array('id');
    protected $canBeRated = true;
    protected $mustBeApproved = false;

}
