<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Actuallymab\LaravelComment\Commentable;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Book extends Model implements TaggableInterface
{
    use TaggableTrait;
    use Commentable;
    
    protected $guarded = array('id');
    protected $canBeRated = true;
    protected $mustBeApproved = false;

	public function supplier(){
        return $this->belongsTo('Bishopm\Connexion\Models\Supplier');
    }

}
