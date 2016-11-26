<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\SettingsRepository;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateSettingRequest;
use bishopm\base\Http\Requests\UpdateSettingRequest;

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
   		return view('base::settings.index',compact('settings'));
	}

	public function edit(Setting $setting)
    {
        return view('base::settings.edit', compact('setting'));
    }

    public function create()
    {
        return view('base::settings.create');
    }

	public function show($setting)
	{
		return "Display setting";
	}

    public function store(CreateSettingRequest $request)
    {
        $this->setting->create($request->all());

        return redirect()->route('admin.settings.index')
            ->withSuccess('New setting added');
    }
	

}
