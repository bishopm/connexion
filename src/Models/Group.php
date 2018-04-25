<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;

class Group extends Model
{
    use Sluggable;
    use SoftDeletes;
    use LogsActivity;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'groupname'
            ]
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('publish', '=', '1');
    }

    public function individuals()
    {
        return $this->belongsToMany('Bishopm\Connexion\Models\Individual')->whereNull('group_individual.deleted_at')->withTimestamps()->orderBy('surname')->orderBy('firstname');
    }

    public function pastmembers()
    {
        return $this->belongsToMany('Bishopm\Connexion\Models\Individual')->whereNotNull('group_individual.deleted_at')->withTimestamps()->withPivot('deleted_at');
    }

    /*
        public function statistic(){
              return $this->belongsToMany('App\Models\Statistic');
        }

        public function society(){
              return $this->belongsTo('App\Models\Society');
        }

        public function selectbox(){
            return array($this->groupname,$this->id);
        }

        public function roster(){
            return $this->belongsToMany('App\Models\Roster');
        }

        public function rosterdetails_roster(){
            return $this->belongsToMany('App\Models\Roster','group_individual_roster');
        }

        public function rosterdetails_individual(){
            return $this->belongsToMany('App\Models\Individual','group_individual_roster');
        }
    */
}
