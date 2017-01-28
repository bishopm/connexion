<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Setitem extends Model
{
    protected $guarded = array('id');

    public function set(){
      return $this->belongsTo('Bishopm\Connexion\Models\Set');
    }

    public function song(){
      return $this->belongsTo('Bishopm\Connexion\Models\Song');
    }
}
