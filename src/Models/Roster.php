<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roster extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');

    public function group(){
		  return $this->belongsToMany('Bishopm\Connexion\Models\Group');
    }

    public function selectbox(){
    	return array($this->rostername,$this->id);
    }

    public function rosterdetails_group(){
		  return $this->belongsToMany('Bishopm\Connexion\Models\Group','group_individual_roster');
    }

    public function rosterdetails_individual(){
		  return $this->belongsToMany('Bishopm\Connexion\Models\Individual','group_individual_roster');
    }

}
