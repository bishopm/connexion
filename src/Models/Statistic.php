<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{

    protected $guarded = array('id');

	public function service(){
        return $this->belongsTo('Bishopm\Connexion\Models\Service');
    }
}
