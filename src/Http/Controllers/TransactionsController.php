<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\TransactionsRepository;
use Bishopm\Connexion\Repositories\BooksRepository;
use Bishopm\Connexion\Models\Transaction;
use Bishopm\Connexion\Models\Book;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateTransactionRequest;
use Bishopm\Connexion\Http\Requests\UpdateTransactionRequest;

class TransactionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $transaction;
    private $book;

    public function __construct(TransactionsRepository $transaction, BooksRepository $book)
    {
        $this->transaction = $transaction;
        $this->book = $book;
    }

    public function index()
    {
        $transactions = $this->transaction->all();
        return view('connexion::transactions.index', compact('transactions'));
    }

    public function edit(Transaction $transaction)
    {
        $books=$this->book->all();
        return view('connexion::transactions.edit', compact('transaction', 'books'));
    }

    public function create()
    {
        $books=$this->book->all();
        return view('connexion::transactions.create', compact('books'));
    }

    public function show(Transaction $transaction)
    {
        $data['transaction']=$transaction;
        return view('connexion::transactions.show', $data);
    }

    public function store(CreateTransactionRequest $request)
    {
        $transaction=$this->transaction->create($request->all());
        $book=Book::find($transaction->book_id);
        if ($transaction->transactiontype=="Add stock") {
            $book->stock=$book->stock + $transaction->units;
        } else {
            $book->stock=$book->stock - $transaction->units;
        }
        $book->save();
        return redirect()->route('admin.transactions.index')
            ->withSuccess('New transaction added');
    }

    public function addinitial($book, $stock)
    {
        $bk=Book::find($book);
        $transaction=$this->transaction->create(['transactiondate'=>'2017-06-01', 'details'=>'Initial stock', 'transactiontype'=>'Add stock','units'=>$stock, 'unitamount'=>$bk->saleprice, 'book_id'=>$bk->id]);
        return redirect()->route('admin.books.index')
            ->withSuccess('Initial stock added');
    }
    
    public function update(Transaction $transaction, UpdateTransactionRequest $request)
    {
        $this->transaction->update($transaction, $request->all());
        return redirect()->route('admin.transactions.index')->withSuccess('Transaction has been updated');
    }

    public function summary()
    {
        $thismonth=date('Y-m');
        $lastday=date('t');
        $data['transactions']=Transaction::where('transactiondate', '>=', $thismonth . '-01')->where('transactiondate', '<=', $thismonth . '-' . $lastday)->orderBy('transactiondate')->get();
        $sales=0;
        foreach ($data['transactions'] as $trans) {
            if (($trans->transactiontype<>'Add stock') and ($trans->transactiontype<>'Shrinkage')) {
                $sales=$sales + $trans->units * $trans->unitamount;
            }
        }
        $data['sales']=number_format($sales, 2);
        return view('connexion::transactions.summary', $data);
    }
}
