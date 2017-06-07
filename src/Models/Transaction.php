<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
	
    protected $guarded = array('id');

    public function book(){
        return $this->belongsTo('Bishopm\Connexion\Models\Book');
    }

} 
