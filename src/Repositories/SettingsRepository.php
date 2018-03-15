<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;
use Bishopm\Connexion\Repositories\SocietiesRepository;
use Bishopm\Connexion\Repositories\CircuitsRepository;

class SettingsRepository extends EloquentBaseRepository
{
    public function getarray()
    {
        return $this->model->all()->toArray();
    }

    public function activemodules()
    {
        $modules=$this->model->where('module', '=', 'module')->where('setting_value', '=', 'yes')->get();
        $fin=array('core');
        foreach ($modules as $module) {
            $fin[]=str_replace('_module', '', $module->setting_key);
        }
        return $fin;
    }

    public function activesettings($modules)
    {
        return $this->model->whereIn('module', $modules)->orderBy('setting_key')->get();
    }

    public function allsettings()
    {
        return $this->model->where('module', '<>', 'module')->orderBy('setting_key')->get();
    }

    public function allmodules()
    {
        return $this->model->where('module', '=', 'module')->get();
    }

    public function makearray()
    {
        $circuit_module=$this->model->where('setting_key', 'mcsa_module')->first();
        if ($circuit_module->setting_value=="yes") {
            $societies=new SocietiesRepository('societies');
        } else {
            $societies="";
        }
        foreach ($this->model->all()->toArray() as $setting) {
            $fin[$setting['setting_key']]=$setting['setting_value'];
            if (($setting['setting_key']=="society_name") and ($setting['setting_value']<>'') and ($societies<>"")) {
                $soc=$societies->find($setting['setting_value']);
                if ((isset($soc->services)) and (count($soc->services))) {
                    foreach ($soc->services as $serv) {
                        $dat[]=$serv->servicetime;
                    }
                    asort($dat);
                    $fin['service_times']="Services: " . implode(',', $dat);
                }
            }
        }
        if ($fin['mcsa_module']=="yes") {
            $circuits=new CircuitsRepository('circuits');
            foreach ($circuits->settings() as $cs) {
                $fin[$cs->setting_key]=$cs->setting_value;
            }
        }
        return $fin;
    }

    public function getkey($key, $module='core')
    {
        $val=$this->model->where('setting_key', $key)->first();
        if ($val) {
            return $val->setting_value;
        } else {
            $this->model->create(['setting_key' => $key,'setting_value' => 'Please add a value for this setting','module' => $module]);
            return "Invalid";
        }
    }
}
