<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $guarded = array('id');

    public function setitem(){
      return $this->belongsTo('bishopm\base\Models\Setitem');
    }

    public function user(){
      return $this->belongsTo('bishopm\base\Models\User');
    }
}
