<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $guarded = array('id');

    public function setitem(){
      return $this->belongsTo('App\Models\Setitem');
    }

    public function user(){
      return $this->belongsTo('App\Models\User');
    }
}
