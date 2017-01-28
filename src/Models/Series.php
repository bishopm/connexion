<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class Series extends Model
{
    use Mediable;
	
    protected $guarded = array('id');

    public function sermons(){
        return $this->hasMany('Bishopm\Connexion\Models\Sermon')->orderBy('created_at');
    }
}
