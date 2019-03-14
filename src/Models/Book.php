<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use BeyondCode\Comments\Traits\HasComments;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Book extends Model implements TaggableInterface
{
    use TaggableTrait;
    use HasComments;
    
    protected $guarded = array('id');
    protected $canBeRated = true;
    protected $mustBeApproved = false;

    public function supplier()
    {
        return $this->belongsTo('Bishopm\Connexion\Models\Supplier');
    }

    public function transactions()
    {
        return $this->hasMany('Bishopm\Connexion\Models\Transaction')->orderBy('transactiondate');
    }
}
