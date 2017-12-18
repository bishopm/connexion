<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = array('id');

    public function actions()
    {
        return $this->hasMany('Bishopm\Connexion\Models\Action');
    }

    public function individuals()
    {
        return $this->belongsToMany('Bishopm\Connexion\Models\Individual');
    }
}
