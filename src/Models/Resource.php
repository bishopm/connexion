<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $guarded = array('id');

    public function ratings(){
        return $this->hasMany('bishopm\base\Models\Rating');
    }
}
