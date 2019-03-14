<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends BeyondCode\Comments\Comment
{
    
    protected $guarded = array('id');

    public function sermon(){
        return $this->belongsTo('Bishopm\Connexion\Models\Sermon');
    }

    public function course(){
        return $this->belongsTo('Bishopm\Connexion\Models\Course');
    }

    public function blog(){
        return $this->belongsTo('Bishopm\Connexion\Models\Blog');
    }

    public function book(){
        return $this->belongsTo('Bishopm\Connexion\Models\Book');
    }
}
