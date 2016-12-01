<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = array('id');

    public function actions(){
        return $this->hasMany('bishopm\base\Models\Action');
    }

	public function individual(){
        return $this->belongsTo('bishopm\base\Models\Individual');
    }   
}
