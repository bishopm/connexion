<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\TransactionsRepository;
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

	private $transaction;

	public function __construct(TransactionsRepository $transaction)
    {
        $this->transaction = $transaction;
    }

	public function index()
	{
        $transactions = $this->transaction->all();
   		return view('connexion::transactions.index',compact('transactions'));
	}

	public function edit(Transaction $transaction)
    {
        return view('connexion::transactions.edit', compact('transaction'));
    }

    public function create()
    {
        return view('connexion::transactions.create');
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