<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\RatingsRepository;
use bishopm\base\Repositories\GroupsRepository;
use bishopm\base\Models\Rating;
use bishopm\base\Models\Resource;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateRatingRequest;
use bishopm\base\Http\Requests\UpdateRatingRequest;
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
   		return view('base::ratings.index',compact('ratings'));
	}

	public function edit(Rating $rating)
    {
        return view('base::ratings.edit', compact('rating'));
    }

    public function create(Resource $resource)
    {
        $groups=$this->groups->all();
        return view('base::ratings.create',compact('resource','groups'));
    }

	public function show(Rating $rating)
	{
        $data['rating']=$rating;
        return view('base::ratings.show',$data);
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