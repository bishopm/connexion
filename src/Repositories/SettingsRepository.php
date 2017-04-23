<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;
use Bishopm\Connexion\Models\Society;

class SettingsRepository extends EloquentBaseRepository
{
	public function getarray()
    {
        return $this->model->all()->toArray();
    }

    public function allsettings()
    {
        return $this->model->where('category','<>','modules')->orderBy('setting_key')->get();
    }

    public function allmodules()
    {
        return $this->model->where('category','=','modules')->get();
    }

    public function makearray(){
    	foreach ($this->model->all()->toArray() as $setting){
    		$fin[$setting['setting_key']]=$setting['setting_value'];
            if (($setting['setting_key']=="society_name") and ($setting['setting_value']<>'')){
                $soc=Society::with('services')->where('society',$setting['setting_value'])->first();
                foreach ($soc->services as $serv){
                    $dat[]=$serv->servicetime;
                }
                asort($dat);
                $fin['service_times']="| Services: " . implode(',',$dat);
            }
    	}
    	return $fin;
    }
}