<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{

    protected $guarded = array('id');

    public function society(){
        return $this->belongsTo('Bishopm\Connexion\Models\Society');
    }

}
