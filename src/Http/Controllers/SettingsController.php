<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Repositories\SocietiesRepository;
use Bishopm\Connexion\Repositories\CircuitsRepository;
use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Repositories\RostersRepository;
use Bishopm\Connexion\Repositories\FoldersRepository;
use Bishopm\Connexion\Repositories\UsersRepository;
use Bishopm\Connexion\Models\Setting;
use Bishopm\Connexion\Models\User;
use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSettingRequest;
use Bishopm\Connexion\Http\Requests\UpdateSettingRequest;
use Spatie\Analytics\Period;
use Analytics;

class SettingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $setting;
    private $societies;
    private $groups;
    private $folders;
    private $circuits;
    private $users;

    public function __construct(SettingsRepository $setting, CircuitsRepository $circuits, SocietiesRepository $societies, GroupsRepository $groups, RostersRepository $rosters, FoldersRepository $folders, UsersRepository $users)
    {
        $this->setting = $setting;
        $this->societies = $societies;
        $this->circuits = $circuits;
        $this->groups = $groups;
        $this->folders = $folders;
        $this->rosters = $rosters;
        $this->users=  $users;
    }

    public function index()
    {
        $modules=$this->setting->activemodules();
        $settings = $this->setting->activesettings($modules);
        return view('connexion::settings.index', compact('settings'));
    }

    public function modulesindex()
    {
        $modules = $this->setting->allmodules();
        return view('connexion::settings.modules', compact('modules'));
    }

    public function modulestoggle($module)
    {
        $modules = $this->setting->allmodules();
        $module = $this->setting->find($module);
        if ($module->setting_value=="yes") {
            $module->setting_value="no";
        } else {
            $module->setting_value="yes";
        }
        $module->save();
        return redirect()->route('admin.modules.index');
    }

    public function edit(Setting $setting)
    {
        if ($setting->setting_key=="society_name") {
            $vals=$this->societies->all();
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val->id;
                $dum[1]=$val->society;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="filtered_tasks") {
            $vals=$this->folders->dropdown();
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val->id;
                $dum[1]=$val->folder;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="giving_reports") {
            $vals=array('0','1','2','3','4','6','12');
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val;
                $dum[1]=$val;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="giving_administrator") {
            $users=User::orderBy('name')->get();
            $count=0;
            foreach ($users as $user) {
                $dropdown[$count][0]=$user->id;
                $dropdown[$count][1]=$user->name;
                $count++;
            }
        } elseif ($setting->setting_key=="pastoral_group") {
            $vals=$this->groups->dropdown();
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val->id;
                $dum[1]=$val->groupname;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="bookshop") {
            $vals=$this->groups->dropdown();
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val->id;
                $dum[1]=$val->groupname;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="birthday_group") {
            $vals=$this->groups->dropdown();
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val->id;
                $dum[1]=$val->groupname;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="worship_roster") {
            $vals=$this->rosters->dropdown();
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val->id;
                $dum[1]=$val->rostername;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="bookshop_manager") {
            $users=User::orderBy('name')->get();
            $count=0;
            foreach ($users as $user) {
                $dropdown[$count][0]=$user->id;
                $dropdown[$count][1]=$user->name;
                $count++;
            }
        } elseif ($setting->setting_key=="website_theme") {
            $dropdown[0][0]="green";
            $dropdown[0][1]="green";
            $dropdown[1][0]="navy";
            $dropdown[1][1]="navy";
        } elseif ($setting->setting_key=="sms_provider") {
            $dropdown[0][0]="bulksms";
            $dropdown[0][1]="bulksms";
            $dropdown[1][0]="smsfactory";
            $dropdown[1][1]="smsfactory";
        } elseif ($setting->setting_key=="worship_administrator") {
            $users=User::orderBy('name')->get();
            $count=0;
            foreach ($users as $user) {
                $dropdown[$count][0]=$user->id;
                $dropdown[$count][1]=$user->name;
                $count++;
            }
        } elseif ($setting->setting_key=="circuit") {
            $circuits=$this->circuits->all();
            $count=0;
            foreach ($circuits as $circuit) {
                $dropdown[$count][0]=$circuit->id;
                $dropdown[$count][1]=$circuit->circuitnumber . ' ' . $circuit->circuit;
                $count++;
            }
        } else {
            $dropdown='';
        }
        return view('connexion::settings.edit', compact('setting', 'dropdown'));
    }

    private function settinglabel($setting)
    {
        if (in_array($setting->setting_key, ["birthday_group","bookshop","pastoral_group"])) {
            $setting->label=$this->groups->find($setting->setting_value)->groupname;
        } elseif (in_array($setting->setting_key, ["circuit"])) {
            $setting->label=$this->circuits->find($setting->setting_value)->circuit;
        } elseif (in_array($setting->setting_key, ["society_name"])) {
            $setting->label=$this->societies->find($setting->setting_value)->society;
        } elseif (in_array($setting->setting_key, ["bookshop_manager","giving_administrator","worship_administrator"])) {
            $user=$this->users->find($setting->setting_value);
            $setting->label=$user->individual->firstname . " " . $user->individual->surname;
        } else {
            $setting->label=$setting->setting_value;
        }
        return $setting->save();
    }

    public function userlogs()
    {
        $activities=Activity::all();
        foreach ($activities as $activity) {
            $user=User::find($activity->causer_id);
            if ($user) {
                $name=$user->individual->firstname . " " . $user->individual->surname;
            } else {
                $name="System";
            }
            if ($activity->subject_type) {
                $obj=$activity->subject_type::find($activity->subject_id);
                $object=substr($activity->subject_type, 1+strrpos($activity->subject_type, '\\'));
                $details=$name . " " . $activity->description . " " . strtolower($object) . " (";
                if ($obj) {
                    if ($object=="Group") {
                        $details.=$obj->groupname . ")";
                    } elseif ($object=="Individual") {
                        $details.=$obj->firstname . " " . $obj->surname . ")";
                    } elseif ($object=="Household") {
                        $details.=$obj->addressee . ")";
                    } elseif ($object=="Song") {
                        $details.=$obj->title . ")";
                    }
                } else {
                    $details.=$activity->subject_id . ")";
                }
            } else {
                $details=$name . " " . $activity->description;
            }
            $activity->details=$details;
        }
        return view('connexion::settings.userlogs', compact('activities'));
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
        self::settinglabel($this->setting->update($setting, $request->all()));
        return redirect()->route('admin.settings.index')->withSuccess('Setting has been updated');
    }

    public function analytics()
    {
        $anal=Analytics::fetchMostVisitedPages(Period::days(7), 75);
        $analytics=array();
        foreach ($anal as $ana) {
            $url=$ana['url'];
            if (array_key_exists($url, $analytics)) {
                $analytics[$url]=$analytics[$url]+$ana['pageViews'];
            } else {
                $analytics[$url]=$ana['pageViews'];
            }
        }
        arsort($analytics);
        return view('connexion::settings.analytics', compact('analytics'));
    }
}
