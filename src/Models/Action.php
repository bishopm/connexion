<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Action extends Model implements TaggableInterface
{
    use TaggableTrait;

    protected $guarded = array('id');

    public function project()
    {
        return $this->belongsTo('bishopm\base\Models\Project');
    }

    public function individual()
    {
        return $this->belongsTo('bishopm\base\Models\Individual');
    }

    public function user()
    {
        return $this->belongsTo('bishopm\base\Models\User');
    }

    public function folder()
    {
        return $this->belongsTo('bishopm\base\Models\Folder');
    }
}
