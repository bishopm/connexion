<?php

namespace Bishopm\Connexion\Models;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    protected $guarded = array('id');

    public function setitems()
    {
        return $this->hasMany('Bishopm\Connexion\Models\Setitem')->orderBy('itemorder');
    }

    public function scopeFourrecent($query, $id)
    {
        $sets = $query->orderBy('created_at', 'DESC')->get()->take(4);
        $fin=array();
        foreach ($sets as $set) {
            $fin[]=$set;
            foreach ($set->setitems as $song) {
                if ($song->song_id==$id) {
                    $addme=false;
                    $set->status="occupied";
                }
            }
        }
        return $fin;
    }
}
