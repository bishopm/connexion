<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\RatingsRepository;
use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Models\Rating;
use Bishopm\Connexion\Models\Resource;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateRatingRequest;
use Bishopm\Connexion\Http\Requests\UpdateRatingRequest;
use Auth;

class RatingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $rating,$groups;

	public function __construct(RatingsRepository $rating, GroupsRepository $groups)
    {
        $this->rating = $rating;
        $this->groups = $groups;
    }

	public function index()
	{
        $ratings = $this->rating->all();
   		return view('connexion::ratings.index',compact('ratings'));
	}

	public function edit(Rating $rating)
    {
        return view('connexion::ratings.edit', compact('rating'));
    }

    public function create(Resource $resource)
    {
        $groups=$this->groups->all();
        return view('connexion::ratings.create',compact('resource','groups'));
    }

	public function show(Rating $rating)
	{
        $data['rating']=$rating;
        return view('connexion::ratings.show',$data);
	}

    public function store($resource, CreateRatingRequest $request)
    {
        $request->request->add(['user_id' => Auth::user()->id]);
        $request->request->add(['resource_id' => $resource]);
        $this->rating->create($request->all());

        return redirect()->route('admin.resources.show',$resource)
            ->withSuccess('New rating added');
    }
	
    public function update(Rating $rating, UpdateRatingRequest $request)
    {
        $this->rating->update($rating, $request->all());
        return redirect()->route('admin.ratings.index')->withSuccess('Rating has been updated');
    }

}