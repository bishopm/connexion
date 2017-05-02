<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Page extends Model implements TaggableInterface
{
	
	use TaggableTrait;

    protected $guarded = array('id');

}
