<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {
	
    protected $guarded = array('id');

    public function books(){
        return $this->hasMany('Bishopm\Connexion\Models\Book')->orderBy('title');
    }

} 
