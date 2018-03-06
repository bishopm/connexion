<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $guarded = array('id');

    public function publishedsermons()
    {
        return $this->hasMany('Bishopm\Connexion\Models\Sermon')->where('status', 'Published')->orderBy('created_at');
    }

    public function sermons()
    {
        return $this->hasMany('Bishopm\Connexion\Models\Sermon')->orderBy('created_at');
    }
}
