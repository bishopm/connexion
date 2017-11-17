<?php

namespace Bishopm\Connexion\Http\Controllers;

use App\Http\Controllers\Controller, MediaUploader;
use Bishopm\Connexion\Models\User;
use Bishopm\Connexion\Models\Role;
use Bishopm\Connexion\Models\Household;
use Bishopm\Connexion\Repositories\UsersRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Http\Requests\CreateUserRequest;
use Bishopm\Connexion\Http\Requests\UpdateUserRequest;
use Bishopm\Connexion\Notifications\ProfileUpdated;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use Auth, JWTAuth;

class UsersController extends Controller {

	private $user,$individuals,$settings;

	public function __construct(UsersRepository $user, IndividualsRepository $individuals, SettingsRepository $settings)
    {
        $this->user = $user;
        $this->settings = $settings;
        $this->individuals = $individuals;
        $this->settingsarray=$this->settings->makearray();
    }

	public function index()
	{
        $users = $this->user->all();
   		return view('connexion::users.index',compact('users'));
	}

    public function activate()
    {
        $users = $this->user->inactive();
        return view('connexion::users.activate',compact('users'));
    }

    public function activateuser($id)
    {
        $user=$this->user->activate($id);
        $webrole=Role::where('slug','web-user')->first()->id;
        $user->roles()->attach($webrole);
        $hid=$user->individual->household_id;
        $household=Household::withTrashed()->where('id',$hid)->first();
        $household->restore();
        UserVerification::generate($user);
        UserVerification::send($user, 'Welcome!');
        return redirect()->route('admin.users.activate')
            ->withSuccess('User has been activated');
    }

	public function edit(User $user)
    {
        $uroles= $user->roles;
        $data['userroles']=array();
        foreach ($uroles as $ur){
            $data['userroles'][]=$ur->id;
        }
        $data['roles']=Role::all();
        $data['individuals'] = $this->individuals->all();
        $data['user'] = $user;
        return view('connexion::users.edit', $data);
    }

	public function show($user)
	{
		if ($user=="current"){
			$data['user']=User::find(1);
		} else {
			$data['user']=User::find($user);
		}
		return view('connexion::users.show',$data);
	}	

    public function create()
    {
        $data['roles']=Role::all();
        $data['individuals'] = $this->individuals->all();

        return view('connexion::users.create',$data);
    }

    public function store(CreateUserRequest $request)
    {
        $user=User::create($request->except('password','role_id'));
        if ($request->input('password')<>""){
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
        $user->roles()->attach($request->role_id);
        return redirect()->route('admin.users.index')
            ->withSuccess('New user added');
    }
	
    public function update($user, UpdateUserRequest $request)
    {
        $user=User::find($user);
        if (null!==$request->input('profile')){
            $individual=$user->individual;
            $fname=$individual->id;
            $individual->servicetime=$request->input('servicetime');
            $individual->image=$request->input('image');
            $individual->save();
            $user->bio=$request->input('bio');
            $user->save();
            //$user->notify(new ProfileUpdated($user));
            return redirect()->route('webuser.edit',$individual->slug)->withSuccess('User profile has been updated');
        } else {
            $user->fill($request->except('role_id','profile'));
            $user->save();
            $user->roles()->detach();
            $user->roles()->attach($request->role_id);        
            //$user->notify(new ProfileUpdated($user));
            return redirect()->route('admin.users.index')->withSuccess('User has been updated');
        }
    }

    public function api_users()
    {
        $users=$this->user->allVerified();
        $services=explode(',',$this->settingsarray['worship_services']);    
        foreach ($users as $user){
            if (isset($user->individual)){
                $user->status=$user->individual->servicetime;
                foreach ($user->individual->tags as $tag){
                    if (strtolower($tag->slug)=="minister"){
                        $user->status="staff " . implode(' ',$services);
                    } elseif (strtolower($tag->slug)=="staff"){
                        $user->status="staff " . $user->status;
                    }
                }
            }
        }
        return $users;
    }

    public function api_user($id)
    {
        $user=$this->user->findWithContent($id);
        return $user;
    }


}
 