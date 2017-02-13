<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\BlogsRepository;
use Bishopm\Connexion\Models\Blog;
use Bishopm\Connexion\Models\Individual;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateBlogRequest;
use Bishopm\Connexion\Http\Requests\UpdateBlogRequest;

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
        $this->bloggers = Individual::withTag('blogger')->get();
    }

	public function index()
	{
        $blogs = $this->blog->all();
   		return view('connexion::blogs.index',compact('blogs'));
	}

	public function edit(Blog $blog)
    {
        $tags=Blog::allTags()->get();
        $btags=array();
        foreach ($blog->tags as $tag){
            $btags[]=$tag->name;
        }
        $bloggers=$this->bloggers;
        return view('connexion::blogs.edit', compact('blog','bloggers','tags','btags'));
    }

    public function create()
    {
        $tags=Blog::allTags()->get();
        $bloggers=$this->bloggers;
        return view('connexion::blogs.create',compact('bloggers','tags'));
    }

	public function show(Blog $blog)
	{
        $data['blog']=$blog;
        return view('connexion::blogs.show',$data);
	}

    public function store(CreateBlogRequest $request)
    {
        $blog=$this->blog->create($request->except('tags'));
        $blog->tag($request->tags);
        return redirect()->route('admin.blogs.index')
            ->withSuccess('New blog post added');
    }
	
    public function update(Blog $blog, UpdateBlogRequest $request)
    {
        $this->blog->update($blog, $request->except('tags'));
        $blog->tag($request->tags);
        return redirect()->route('admin.blogs.index')->withSuccess('Blog has been updated');
    }

    public function addtag($blog, $tag)
    {
        $bb=Blog::find($blog);
        $bb->tag($tag);
    }

    public function removetag($blog, $tag)
    {
        $bb=Blog::find($blog);
        $bb->untag($tag);
    }

}