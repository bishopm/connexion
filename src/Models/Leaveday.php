<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Leaveday extends Model
{
    protected $guarded = array('id');

    public function employee()
    {
        return $this->belongsTo('Bishopm\Connexion\Models\Employee');
    }
}
