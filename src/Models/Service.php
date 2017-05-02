<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $guarded = array('id');

	public function society(){
        return $this->belongsTo('Bishopm\Connexion\Models\Society');
    }

    public function statistics(){
        return $this->hasMany('Bishopm\Connexion\Models\Statistic');
    }
}
