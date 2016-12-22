<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\RatingsRepository;
use bishopm\base\Models\Rating;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateRatingRequest;
use bishopm\base\Http\Requests\UpdateRatingRequest;

class RatingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $rating;

	public function __construct(RatingsRepository $rating)
    {
        $this->rating = $rating;
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

    public function create()
    {
        return view('base::ratings.create');
    }

	public function show(Rating $rating)
	{
        $data['rating']=$rating;
        return view('base::ratings.show',$data);
	}

    public function store(CreateRatingRequest $request)
    {
        $this->rating->create($request->all());

        return redirect()->route('admin.ratings.index')
            ->withSuccess('New rating added');
    }
	
    public function update(Rating $rating, UpdateRatingRequest $request)
    {
        $this->rating->update($rating, $request->all());
        return redirect()->route('admin.ratings.index')->withSuccess('Rating has been updated');
    }

}