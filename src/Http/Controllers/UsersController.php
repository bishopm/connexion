<?php

namespace bishopm\base\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use bishopm\base\Models\User;
use bishopm\base\Models\Role;
use bishopm\base\Repositories\UsersRepository;
use bishopm\base\Repositories\IndividualsRepository;
use bishopm\base\Repositories\RolesRepository;
use bishopm\base\Http\Requests\CreateUserRequest;
use bishopm\base\Http\Requests\UpdateUserRequest;

class UsersController extends Controller {

	private $user,$individuals;

	public function __construct(UsersRepository $user, IndividualsRepository $individuals, RolesRepository $roles)
    {
        $this->user = $user;
        $this->individuals = $individuals;
        $this->roles = $roles;
    }

	public function index()
	{
        $users = $this->user->all();
   		return view('base::users.index',compact('users'));
	}

	public function edit(User $user)
    {
        $uroles= $user->roles()->get();
        foreach ($uroles as $ur){
            $data['userroles'][]=$ur->id;
        }
        $data['roles']=$this->roles->all();
        $data['individuals'] = $this->individuals->all();
        $data['user'] = $user;
        return view('base::users.edit', $data);
    }


	public function show($user)
	{
		if ($user=="current"){
			$data['user']=User::find(1);
		} else {
			$data['user']=User::find($user);
		}
		return view('base::users.show',$data);
	}	

    public function create()
    {
        $data['roles']=$this->roles->all();
        $data['individuals'] = $this->individuals->all();

        return view('base::users.create',$data);
    }

    public function store(CreateUserRequest $request)
    {
        $user=User::create($request->except('password','role_id'));
        if ($request->input('password')<>""){
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        $user->roles()->attach($request->role_id);
        return redirect()->route('admin.users.index')
            ->withSuccess('New user added');
    }
	
    public function update(User $user, UpdateUserRequest $request)
    {
        $user->roles()->detach();
        $user->roles()->attach($request->role_id);

        $user->fill($request->except('password','role_id'));
        if ($request->input('password')<>""){
            $user->password = Hash::make($request->input('password'));
            $user->save();
        }
        return redirect()->route('admin.users.index')->withSuccess('User has been updated');
    }


}
 