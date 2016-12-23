<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\BlogsRepository;
use bishopm\base\Models\Blog;
use bishopm\base\Models\Individual;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateBlogRequest;
use bishopm\base\Http\Requests\UpdateBlogRequest;

class BlogsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $blog;

	public function __construct(BlogsRepository $blog)
    {
        $this->blog = $blog;
        $tag=Tag::find('blogger');
        $this->bloggers = Individual::withAnyTags($tag)->get();
        dd($this->bloggers);
    }

	public function index()
	{
        $blogs = $this->blog->all();
   		return view('base::blogs.index',compact('blogs'));
	}

	public function edit(Blog $blog)
    {
        return view('base::blogs.edit', compact('blog'));
    }

    public function create()
    {
        $bloggers=$this->bloggers;
        return view('base::blogs.create',compact('bloggers'));
    }

	public function show(Blog $blog)
	{
        $data['blog']=$blog;
        return view('base::blogs.show',$data);
	}

    public function store(CreateBlogRequest $request)
    {
        $this->blog->create($request->all());

        return redirect()->route('admin.blogs.index')
            ->withSuccess('New blog added');
    }
	
    public function update(Blog $blog, UpdateBlogRequest $request)
    {
        $this->blog->update($blog, $request->all());
        return redirect()->route('admin.blogs.index')->withSuccess('Blog has been updated');
    }

}