<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setitem extends Model
{
    protected $guarded = array('id');

    public function set(){
      return $this->belongsTo('App\Models\Set');
    }

    public function song(){
      return $this->belongsTo('App\Models\Song');
    }
}
