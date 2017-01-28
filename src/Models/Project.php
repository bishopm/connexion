<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = array('id');

    public function actions(){
        return $this->hasMany('Bishopm\Connexion\Models\Action');
    }

	public function individual(){
        return $this->belongsTo('Bishopm\Connexion\Models\Individual');
    }   
}
