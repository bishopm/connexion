<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\BooksRepository;
use Bishopm\Connexion\Repositories\UsersRepository;
use Bishopm\Connexion\Models\Book;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateBookRequest;
use Bishopm\Connexion\Http\Requests\UpdateBookRequest;
use Bishopm\Connexion\Http\Requests\CreateCommentRequest;
use MediaUploader;
use Plank\Mediable\Media;

class BooksController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $book, $user;

	public function __construct(BooksRepository $book, UsersRepository $user)
    {
        $this->book = $book;
        $this->user = $user;
    }

	public function index()
	{
        $books = $this->book->all();
   		return view('connexion::books.index',compact('books'));
	}

	public function edit(Book $book)
    {
        $tags=Book::allTags()->get();
        $btags=array();
        foreach ($book->tags as $tag){
            $btags[]=$tag->name;
        }
        $media=$book->getMedia('image')->first()->getUrl();
        return view('connexion::books.edit', compact('book','media','tags','btags'));
    }

    public function create()
    {
        $media='';
        $tags=Book::allTags()->get();
        return view('connexion::books.create',compact('media','tags'));
    }

	public function show($slug)
	{
        $data['book']=$this->book->findBySlug($slug);
        $data['comments'] = $data['book']->comments()->paginate(5);
        return view('connexion::site.book',$data);
	}

    public function store(CreateBookRequest $request)
    {
        $book=$this->book->create($request->except('image','files','tags'));
        $book->tag($request->tags);
        $fname=explode('.',$request->input('image'));
        $media=Media::where('disk','=','public')->where('directory','=','books')->where('filename','=',$fname[0])->where('extension','=',$fname[1])->first();
        if (!$media){
            $media = MediaUploader::import('public', 'books', $fname[0], $fname[1]);
        }
        $book->attachMedia($media, 'image');
        return redirect()->route('admin.books.index')
            ->withSuccess('New book added');
    }
	
    public function update(Book $book, UpdateBookRequest $request)
    {      
        $file_name=substr($request->input('image'),strrpos($request->input('image'),'/'));   
        if ($book->media[0]->filename . '.' . $book->media[0]->extension <> $file_name){
            // New image
            $fname=explode('.',$file_name);
            $media=Media::where('disk','=','public')->where('directory','=','books')->where('filename','=',$fname[0])->where('extension','=',$fname[1])->first();
            if (!$media){
                $media = MediaUploader::import('public', 'books', $fname[0], $fname[1]);
            }
            $book->syncMedia($media, 'image');
        } 
        $this->book->update($book, $request->except('image','files','tags'));
        $book->tag($request->tags);
        return redirect()->route('admin.books.index')->withSuccess('Book has been updated');
    }

    public function removemedia(Book $book)
    {
        $media = $book->getMedia('image');
        $book->detachMedia($media);
    }

    public function addcomment(Book $book, CreateCommentRequest $request)
    {
        $user=$this->user->find($request->user);
        $user->comment($book, $request->newcomment, $request->rating);
    }

    public function addtag($book, $tag)
    {
        $bb=Book::find($book);
        $bb->tag($tag);
    }

    public function removetag($book, $tag)
    {
        $bb=Book::find($book);
        $bb->untag($tag);
    }

}