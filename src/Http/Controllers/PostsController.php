<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\PostsRepository;
use Bishopm\Connexion\Models\Post;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreatePostRequest;
use Bishopm\Connexion\Http\Requests\UpdatePostRequest;

class PostsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $post;

	public function __construct(PostsRepository $post)
    {
        $this->post = $post;
    }

	public function index()
	{
        $fposts = $this->post->alltitles();
        $posts=array();
        foreach ($fposts as $post){
            $post->replies=$this->post->countreplies($post->id);
            $posts[]=$post;
        }
   		return view('connexion::posts.index',compact('posts'));
	}

	public function edit(Post $post)
    {
        return view('connexion::posts.edit', compact('post'));
    }

    public function show(Post $post)
    {
        $replies=$this->post->getreplies($post->id);
        return view('connexion::posts.show', compact('post','replies'));
    }

    public function create()
    {
        return view('connexion::posts.create');
    }

    public function store(CreatePostRequest $request)
    {
        $this->post->create($request->except('files'));

        return redirect()->route('posts.index')
            ->withSuccess('New post added');
    }
	
    public function update(Post $post, UpdatePostRequest $request)
    {
        $this->post->update($post, $request->all());
        return redirect()->route('posts.index')->withSuccess('Post has been updated');
    }

}