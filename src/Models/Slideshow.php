<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
	
    protected $guarded = array('id');

	public function slides(){
        return $this->hasMany('Bishopm\Connexion\Models\Slide')->orderBy('rankorder');
    }

}
