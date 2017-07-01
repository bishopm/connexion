<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\BooksRepository;
use Bishopm\Connexion\Repositories\UsersRepository;
use Bishopm\Connexion\Repositories\SuppliersRepository;
use Bishopm\Connexion\Models\Book;
use Bishopm\Connexion\Models\User;
use Bishopm\Connexion\Models\Setting;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateBookRequest;
use Bishopm\Connexion\Http\Requests\CreateOrderRequest;
use Bishopm\Connexion\Http\Requests\UpdateBookRequest;
use Bishopm\Connexion\Http\Requests\CreateCommentRequest;
use Bishopm\Connexion\Mail\GenericMail;
use Illuminate\Support\Facades\Mail;

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
        if ($data['book']){
            $data['authors']=explode(',',$data['book']->author);
            $data['comments'] = $data['book']->comments()->paginate(5);
            $data['fulltitle'] = $data['book']->title . " (" . $data['book']->author . ")";
            $data['messagetxt'] = "I would like to buy a copy of: " . $data['fulltitle'] . ". When you email to confirm the book is ready for collection, I will bring cash or proof of payment of R" . $data['book']->saleprice . " to the church office. Thanks!";
            return view('connexion::site.book',$data);
        } else {
            abort(404);
        }
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

    public function getbook(Book $book)
    {
        return $book;
    }

    public function placeorder(CreateOrderRequest $request){
        $data = new \StdClass;
        $data->subject=$request->input('title');
        $data->sender=$request->input('email');
        $data->emailmessage=$request->input('message') . "<br><br>" . $request->input('name');
        $officeemail=Setting::where('setting_key','church_email')->first()->setting_value;
        $bookshopuser=Setting::where('setting_key','bookshop_manager')->first()->setting_value;
        $manager=User::where('name',$bookshopuser)->first();
        Mail::to($officeemail)->cc($data->sender)->bcc($manager->individual->email)->send(new GenericMail($data));
        return redirect()->route('webbooks')->withSuccess('Thank you! Your order has been emailed to us');
    }

    public function destroy($id)
    {
        $book=$this->book->find($id);
        $supplier=$book->supplier_id;
        $book->delete();
        return redirect()->route('admin.suppliers.edit',$supplier)->withSuccess('Book has been deleted');
    }

    public function booksapi()
    {
        $books=Book::OrderBy('title')->select('id','title','author','image','saleprice','description')->get();
        return $books;
    }

}