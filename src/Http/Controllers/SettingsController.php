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
        $settings = $this->setting->all();
        return view('connexion::settings.index',compact('settings'));
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