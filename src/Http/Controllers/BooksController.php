<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\BooksRepository;
use Bishopm\Connexion\Repositories\UsersRepository;
use Bishopm\Connexion\Repositories\SuppliersRepository;
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

	private $book, $user, $suppliers;

	public function __construct(BooksRepository $book, UsersRepository $user, SuppliersRepository $suppliers)
    {
        $this->book = $book;
        $this->user = $user;
        $this->suppliers = $suppliers;
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
        $suppliers=$this->suppliers->all();
        return view('connexion::books.edit', compact('book','tags','btags','suppliers'));
    }

    public function create()
    {
        $tags=Book::allTags()->get();
        $suppliers=$this->suppliers->all();
        return view('connexion::books.create',compact('tags','suppliers'));
    }

	public function show($slug)
	{
        $data['book']=$this->book->findBySlug($slug);
        $data['authors']=explode(',',$data['book']->author);
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