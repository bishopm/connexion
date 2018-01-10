<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = array('id');

    public function individual()
    {
        return $this->belongsTo('Bishopm\Connexion\Models\Individual');
    }

    public function leavedays()
    {
        return $this->hasMany('Bishopm\Connexion\Models\Leaveday');
    }
}
