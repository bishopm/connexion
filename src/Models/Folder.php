<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $guarded = array('id');

    public function actions(){
        return $this->hasMany('bishopm\base\Models\Action');
    }
}
