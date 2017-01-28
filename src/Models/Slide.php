<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class Slide extends Model
{
    use Mediable;
	
    protected $guarded = array('id');

}
