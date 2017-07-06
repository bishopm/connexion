<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\BlogsRepository;
use Bishopm\Connexion\Repositories\UsersRepository;
use Bishopm\Connexion\Models\Blog;
use Bishopm\Connexion\Models\User;
use Bishopm\Connexion\Models\Individual;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateBlogRequest;
use Bishopm\Connexion\Http\Requests\UpdateBlogRequest;
use Bishopm\Connexion\Http\Requests\CreateCommentRequest;
use Bishopm\Connexion\Notifications\NewBlogPost;
use Bishopm\Connexion\Notifications\NewBlogComment;
use MediaUploader;

class BlogsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $blog,$user;

	public function __construct(BlogsRepository $blog, UsersRepository $user)
    {
        $this->blog = $blog;
        $this->user = $user;
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
        $media=Blog::find($blog->id)->getMedia('image')->first();
        $btags=array();
        foreach ($blog->tags as $tag){
            $btags[]=$tag->name;
        }
        $bloggers=$this->bloggers;
        return view('connexion::blogs.edit', compact('blog','bloggers','tags','btags','media'));
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
        $request->request->add(['created_at' => $request->input('created_at') . ":00"]);
        $blog=$this->blog->create($request->except('tags','files','image'));
        $blog->tag($request->tags);
        if ($request->file('image')){
            $fname=$blog->id;
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('blogs')->useFilename($fname)->upload();
            $blog->attachMedia($media, 'image');
        }
        $admin=User::find(1);
        $admin->notify(new NewBlogPost("A new blog post has been created. Check it and publish it when ready."));
        return redirect()->route('admin.blogs.index')
            ->withSuccess('New blog post added');
    }
	
    public function update(Blog $blog, UpdateBlogRequest $request)
    {
        $request->request->add(['created_at' => $request->input('created_at') . ":00"]);
        $this->blog->update($blog, $request->except('tags','files','image'));
        $blog->tag($request->tags);
        if ($request->file('image')){
            $fname=$blog->id;
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('blogs')->useFilename($fname)->upload();
            $blog->attachMedia($media, 'image');
        }
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

    public function removemedia(Blog $blog)
    {
        $media = $blog->getMedia('image');
        $blog->detachMedia($media);
    }

    public function addcomment(Blog $blog, CreateCommentRequest $request)
    {
        $user=$this->user->find($request->user);
        $author=$blog->individual->user;
        $user->comment($blog, $request->newcomment);
        $message=$user->individual->firstname . " " . $user->individual->surname . " has posted a comment on your blog post: '" . $blog->title . "'";
        $author->notify(new NewBlogComment($message));
    }

    public function apiblog($id){
        if ($id=="current"){
            $blog=Blog::with('individual')->where('status','published')->orderBy('created_at','DESC')->first();
        } else {
            $blog=Blog::with('individual')->where('id',$id)->first();
        }
        $data=array();
        foreach ($blog->comments as $comment){
            $author=$this->user->find($comment->commented_id);
            $comment->author = $author->individual->firstname . " " . $author->individual->surname;
            $comment->image = "http://umc.org.za/public/storage/individuals/" . $author->individual_id . "/" . $author->individual->image;
        }
        $data['comments']=$blog->comments;
        $data['title']=$blog->title;
        $data['body']=$blog->body;
        $data['author']=$blog->individual->firstname . " " . $blog->individual->surname;
        $data['pubDate']=date("j F Y",strtotime($blog->created_at));
        $data['tags']=$blog->tags;
        return $data;
    }

    public function apiblogs(){
        $blogs=array();
        $dum=array();
        $allblogs=Blog::with('individual')->where('status','published')->orderBy('created_at','DESC')->get();
        foreach ($allblogs as $blog){
            $dum['title']=$blog->title;
            $dum['body']=$blog->body;
            $dum['author']=$blog->individual->firstname . " " . $blog->individual->surname;
            $dum['pubDate']=date("d M Y",strtotime($blog->created_at));
            $dum['id']=$blog->id;
            $dum['tags']=$blog->tags;
            $blogs[]=$dum;
        }
        return $blogs;
    }

}