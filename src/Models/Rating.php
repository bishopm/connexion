<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $guarded = array('id');

	public function group(){
        return $this->belongsTo('bishopm\base\Models\Group');
    }

    public function resource(){
        return $this->belongsTo('bishopm\base\Models\Resource');
    }

}
