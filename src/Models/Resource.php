<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class Resource extends Model
{
    use Mediable;
    
    protected $guarded = array('id');

    public function ratings(){
        return $this->hasMany('bishopm\base\Models\Rating');
    }
}
