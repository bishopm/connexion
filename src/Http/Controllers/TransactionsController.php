<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\TransactionsRepository;
use Bishopm\Connexion\Repositories\BooksRepository;
use Bishopm\Connexion\Models\Transaction;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateTransactionRequest;
use Bishopm\Connexion\Http\Requests\UpdateTransactionRequest;

class TransactionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $transaction, $book;

	public function __construct(TransactionsRepository $transaction, BooksRepository $book)
    {
        $this->transaction = $transaction;
        $this->book = $book;
    }

	public function index()
	{
        $transactions = $this->transaction->all();
   		return view('connexion::transactions.index',compact('transactions'));
	}

	public function edit(Transaction $transaction)
    {
        $books=$this->book->all();
        return view('connexion::transactions.edit', compact('transaction','books'));
    }

    public function create()
    {
        $books=$this->book->all();
        return view('connexion::transactions.create', compact('books'));
    }

	public function show(Transaction $transaction)
	{
        $data['transaction']=$transaction;
        return view('connexion::transactions.show',$data);
	}

    public function store(CreateTransactionRequest $request)
    {
        $this->transaction->create($request->all());

        return redirect()->route('admin.transactions.index')
            ->withSuccess('New transaction added');
    }
	
    public function update(Transaction $transaction, UpdateTransactionRequest $request)
    {
        $this->transaction->update($transaction, $request->all());
        return redirect()->route('admin.transactions.index')->withSuccess('Transaction has been updated');
    }

}