<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Song extends Model implements TaggableInterface
{
	use TaggableTrait;

    protected $guarded = array('id');

    public function setitem(){
      return $this->belongsTo('Bishopm\Connexion\Models\Setitem');
    }

    public function user(){
      return $this->belongsTo('Bishopm\Connexion\Models\User');
    }

    public function scopeTitle($query,$filter)
    {
        return $query->where('title', 'like', '%' . $filter . '%');
    }

    public function scopeAuthor($query,$filter)
    {
        return $query->orWhere('author', 'like', '%' . $filter . '%');
    }

    public function scopeWords($query,$filter)
    {
        return $query->orWhere('words', 'like', '%' . $filter . '%');
    }
}
