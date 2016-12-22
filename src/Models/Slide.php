<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class Slide extends Model
{
    use Mediable;
	
    protected $guarded = array('id');
}
