<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Sermon extends Model implements TaggableInterface
{

    use TaggableTrait;

    protected $guarded = array('id');


    public function series(){
        return $this->belongsTo('bishopm\base\Models\Series');
    }
    
    public function individual(){
        return $this->belongsTo('bishopm\base\Models\Individual');
    }
}
