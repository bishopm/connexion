<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $guarded = array('id');

	public function society(){
        return $this->belongsTo('bishopm\base\Models\Society');
    }
}
