<?php

namespace bishopm\base\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Household extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');

    public function individuals(){
        return $this->hasMany('bishopm\base\Models\Individual')->orderBy('firstname');
    }

    public function getPhysicaladdressAttribute(){
        if (!$this->addr3){
            if (!$this->addr2){
                return trim($this->addr1);
            } else {
                return trim($this->addr1) . ", " . trim($this->addr2);
            }
        } else {
            return trim($this->addr1) . ", " . trim($this->addr2) . ", " . $this->addr3;
        }
    }

    public function getPostaladdressAttribute(){
        if (!$this->post3){
            if (!$this->post2){
                return trim($this->post1);
            } else {
                return trim($this->post1) . ", " . trim($this->post2);
            }
        } else {
            return trim($this->post1) . ", " . trim($this->post2) . ", " . $this->post3;
        }
    }

    public function specialdays(){
        return $this->hasMany('bishopm\base\Models\Specialday');
    }

    public function pastorals(){
        return $this->hasMany('bishopm\base\Models\Pastoral');
    }
/*
    public function pastoral(){
		  return $this->hasMany('App\Models\Pastoral')->orderBy('diarydate','des');
    }

    public function selectbox(){
    	return array($this->addressee,$this->id);
    }
    */
}
