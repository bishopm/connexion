<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = array('id');

    public function user(){
        return $this->belongsTo('Bishopm\Connexion\Models\User');
    }

}
