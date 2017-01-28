<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $guarded = array('id');

	public function group(){
        return $this->belongsTo('Bishopm\Connexion\Models\Group');
    }

    public function resource(){
        return $this->belongsTo('Bishopm\Connexion\Models\Resource');
    }

}
