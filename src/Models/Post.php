<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = array('id');

    public function user(){
        return $this->belongsTo('Bishopm\Connexion\Models\User');
    }

    public function scopeThreadtitle($query,$thread)
    {
        return $query->where('id',$thread)->first();
    }
}
