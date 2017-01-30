<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Setting;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSettingRequest;
use Bishopm\Connexion\Http\Requests\UpdateSettingRequest;

class SettingsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $setting;

    public function __construct(SettingsRepository $setting)
    {
        $this->setting = $setting;
    }

    public function index()
    {
        $settings = $this->setting->allsettings();
        return view('connexion::settings.index',compact('settings'));
    }

    public function modulesindex()
    {
        $modules = $this->setting->allmodules();
        return view('connexion::settings.modules',compact('modules'));
    }

    public function modulestoggle($module)
    {
        $modules = $this->setting->allmodules();
        $module = $this->setting->find($module);
        if ($module->setting_value=="yes"){
            $module->setting_value="no";
        } else {
            $module->setting_value="yes";
        }
        $module->save();
        return redirect()->route('admin.modules.index');
    }    

    public function edit(Setting $setting)
    {
        return view('connexion::settings.edit', compact('setting'));
    }

    public function create()
    {
        return view('connexion::settings.create');
    }

    public function store(CreateSettingRequest $request)
    {
        $this->setting->create($request->all());

        return redirect()->route('admin.settings.index')
            ->withSuccess('New setting added');
    }
    
    public function update(Setting $setting, UpdateSettingRequest $request)
    {
        $this->setting->update($setting, $request->all());
        return redirect()->route('admin.settings.index')->withSuccess('Setting has been updated');
    }

}