<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    protected $guarded = array('id');

	public function preacher(){
        return $this->belongsTo('Bishopm\Connexion\Models\Preacher');
    }

}
