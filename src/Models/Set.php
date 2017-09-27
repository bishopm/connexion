<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    protected $guarded = array('id');

    public function setitems(){
      return $this->hasMany('Bishopm\Connexion\Models\Setitem');
    }
}
