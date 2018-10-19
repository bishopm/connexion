<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

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
        $societies="";
        foreach ($this->model->all()->toArray() as $setting) {
            $fin[$setting['setting_key']]=$setting['setting_value'];
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
