<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\BooksRepository;
use Bishopm\Connexion\Repositories\UsersRepository;
use Bishopm\Connexion\Models\Book;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateBookRequest;
use Bishopm\Connexion\Http\Requests\UpdateBookRequest;
use Bishopm\Connexion\Http\Requests\CreateCommentRequest;

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
        return view('connexion::books.edit', compact('book','tags','btags'));
    }

    public function create()
    {
        $tags=Book::allTags()->get();
        return view('connexion::books.create',compact('tags'));
    }

	public function show($slug)
	{
        $data['book']=$this->book->findBySlug($slug);
        $data['comments'] = $data['book']->comments()->paginate(5);
        return view('connexion::site.book',$data);
	}

    public function store(CreateBookRequest $request)
    {
        $book=$this->book->create($request->except('files','tags'));
        $book->tag($request->tags);
        return redirect()->route('admin.books.index')
            ->withSuccess('New book added');
    }
	
    public function update(Book $book, UpdateBookRequest $request)
    {      
        $this->book->update($book, $request->except('files','tags'));
        $book->tag($request->tags);
        return redirect()->route('admin.books.index')->withSuccess('Book has been updated');
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