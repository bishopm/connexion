<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use Sluggable;

    protected $guarded = array('id');

    public function individuals(){
		  return $this->belongsToMany('bishopm\base\Models\Individual')->whereNull('group_individual.deleted_at')->withTimestamps()->orderBy('surname')->orderBy('firstname');
    }

    public function household(){
        return $this->belongsTo('bishopm\base\Models\Household');
    }

}
