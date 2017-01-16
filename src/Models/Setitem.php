<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;

class Setitem extends Model
{
    protected $guarded = array('id');

    public function set(){
      return $this->belongsTo('bishopm\base\Models\Set');
    }

    public function song(){
      return $this->belongsTo('bishopm\base\Models\Song');
    }
}
