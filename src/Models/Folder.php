<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $guarded = array('id');

    public function actions(){
        return $this->hasMany('Bishopm\Connexion\Models\Action');
    }
}
