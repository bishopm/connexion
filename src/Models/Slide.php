<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
	
    protected $guarded = array('id');

	public function slideshow(){
        return $this->belongsTo('Bishopm\Connexion\Models\Slideshow');
    }

}
