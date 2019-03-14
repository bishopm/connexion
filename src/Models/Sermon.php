<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;
use BeyondCode\Comments\Traits\HasComments;

class Sermon extends Model implements TaggableInterface
{
    use TaggableTrait;
    use HasComments;

    protected $guarded = array('id');
	protected $mustBeApproved = false;

    public function series(){
        return $this->belongsTo('Bishopm\Connexion\Models\Series');
    }
    
    public function individual(){
        return $this->belongsTo('Bishopm\Connexion\Models\Individual');
    }

}