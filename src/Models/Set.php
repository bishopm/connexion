<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    protected $guarded = array('id');

    public function service(){
      return $this->belongsTo('App\Models\Service');
    }

    public function setitems(){
      return $this->hasMany('App\Models\Setitem');
    }
}
