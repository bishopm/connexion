<?php

namespace bishopm\base\Http\Controllers;

use App\Http\Controllers\Controller;
use bishopm\base\Models\User;
use bishopm\base\Repositories\UsersRepository;
use bishopm\base\Repositories\IndividualsRepository;
use bishopm\base\Http\Requests\CreateUserRequest;
use bishopm\base\Http\Requests\UpdateUserRequest;

class UsersController extends Controller {

	private $user,$individuals;

	public function __construct(UsersRepository $user, IndividualsRepository $individuals)
    {
        $this->user = $user;
        $this->individuals = $individuals;
    }

	public function index()
	{
        $users = $this->user->all();
   		return view('base::users.index',compact('users'));
	}

	public function edit(User $user)
    {
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
        return view('base::users.create');
    }

    public function store(CreateUserRequest $request)
    {
        $this->user->create($request->all());

        return redirect()->route('admin.users.index')
            ->withSuccess('New user added');
    }
	
    public function update(User $user, UpdateUserRequest $request)
    {
        $this->user->update($user, $request->all());
        return redirect()->route('admin.users.index')->withSuccess('User has been updated');
    }


}
 