<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use BeyondCode\Comments\Traits\HasComments;

class Course extends Model
{
    use HasComments;
    
    protected $guarded = array('id');
    protected $canBeRated = true;
    protected $mustBeApproved = false;

	public function group(){
      return $this->belongsTo('Bishopm\Connexion\Models\Group');
    }

}
