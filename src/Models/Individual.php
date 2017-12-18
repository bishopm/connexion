<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;
use Spatie\Activitylog\Traits\LogsActivity;

class Individual extends Model implements TaggableInterface
{
    use Sluggable;
    use SoftDeletes;
    use TaggableTrait;
    use LogsActivity;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['firstname', 'surname']
            ]
        ];
    }

    public function getFullnameAttribute()
    {
        return $this->firstname . " " . $this->surname;
    }

    public function groups()
    {
        return $this->belongsToMany('Bishopm\Connexion\Models\Group')->whereNull('group_individual.deleted_at')->withTimestamps();
    }

    public function publishedgroups()
    {
        return $this->belongsToMany('Bishopm\Connexion\Models\Group')->where('publish', 1)->where('grouptype', '<>', 'event')->whereNull('group_individual.deleted_at')->withTimestamps();
    }

    public function publishedevents()
    {
        return $this->belongsToMany('Bishopm\Connexion\Models\Group')->where('publish', 1)->where('grouptype', 'event')->whereNull('group_individual.deleted_at')->withTimestamps();
    }

    public function pastgroups()
    {
        return $this->belongsToMany('Bishopm\Connexion\Models\Group')->whereNotNull('group_individual.deleted_at')->withTimestamps()->withPivot('deleted_at');
    }

    public function household()
    {
        return $this->belongsTo('Bishopm\Connexion\Models\Household');
    }

    public function blogs()
    {
        return $this->hasMany('Bishopm\Connexion\Models\Blog');
    }

    public function sermons()
    {
        return $this->hasMany('Bishopm\Connexion\Models\Sermon');
    }

    public function user()
    {
        return $this->hasOne('Bishopm\Connexion\Models\User');
    }

    public function projects()
    {
        return $this->belongsToMany('Bishopm\Connexion\Models\Project')->whereNull('project_individual.deleted_at')->withTimestamps();
    }

    /*    public function getAgeAttribute(){
            if ($this->birthdate>'1901-01-01'){
                return Carbon::now()
                ->diffInYears(Carbon::createFromDate(date("Y",strtotime($this->birthdate)),
                 date("n",strtotime($this->birthdate)), date("j",strtotime($this->birthdate))));
            } else {
                return false;
            }
        }
    
    
    
        public function scopeMembers($query){
          return $query->where('memberstatus','=','member');
        }
    
        public function scopeSocindiv($query,$society_id){
            if (is_array($society_id)){
                return $query->join('households','households.id','=','individuals.household_id')->wherein('households.society_id',$society_id)->orderBy('surname')->orderBy('firstname')->select('individuals.id','individuals.surname','individuals.firstname','individuals.leadership','individuals.slug','individuals.birthdate','households.society_id','individuals.household_id');
            } else {
                return $query->join('households','households.id','=','individuals.household_id')->where('households.society_id','=',$society_id)->orderBy('surname')->orderBy('firstname')->select('individuals.id','individuals.surname','individuals.firstname','individuals.leadership','individuals.slug','individuals.birthdate','households.society_id','individuals.household_id');
            }
        }
    
        public function scopeSocindivrecent($query,$society_id){
            if (is_array($society_id)){
                return $query->join('households','households.id','=','individuals.household_id')->wherein('households.society_id',$society_id)->select('individuals.id','individuals.surname','individuals.firstname','individuals.leadership','individuals.slug','individuals.birthdate','households.society_id','individuals.household_id');
            } else {
                return $query->join('households','households.id','=','individuals.household_id')->where('households.society_id','=',$society_id)->select('individuals.id','individuals.surname','individuals.firstname','individuals.leadership','individuals.slug','individuals.birthdate','households.society_id','individuals.household_id');
            }
        }
    
        public function scopeAdherents($query){
          return $query->where('memberstatus','=','adherent');
        }
    
        public function scopeChildren($query){
            return $query->where('memberstatus','=','child');
        }
    
        public function scopeAged($query){
          return $query->where('birthdate','>','1901-01-01');
        }
    
        public function currentgroups(){
            return $this->belongsToMany('App\Models\Group')->whereNull('group_individual.deleted_at')->withTimestamps();
        }
    
        public function pastgroups(){
            return $this->belongsToMany('App\Models\Group')->whereNotNull('group_individual.deleted_at')->withTimestamps();
        }
    
        public function portfolio(){
            return $this->belongsToMany('App\Models\Portfolio');
        }
    
        public function skill(){
            return $this->belongsToMany('App\Models\Skill');
        }
    
        public function task(){
            return $this->belongsTo('App\Models\Task');
        }
    
        public function user(){
                return $this->hasOne('App\Models\User');
        }
    
        public function selectbox(){
            return array($this->firstname . " " . $this->surname,$this->id);
        }
    
        public function rosterdetails_roster(){
                return $this->belongsToMany('App\Models\Roster','group_individual_roster');
        }
    
        public function rosterdetails_group(){
                return $this->belongsToMany('App\Models\Group','group_individual_roster');
        }
    */
}
