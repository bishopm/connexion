<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class SettingsRepository extends EloquentBaseRepository
{
	public function getarray()
    {
        return $this->model->all()->toArray();
    }

    public function makearray(){
    	foreach ($this->model->all()->toArray() as $setting){
    		$fin[$setting['setting_key']]=$setting['setting_value'];
    	}
    	return $fin;
    }
}