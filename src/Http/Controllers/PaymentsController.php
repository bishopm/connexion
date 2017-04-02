<?php

namespace Bishopm\Connexion\Http\Controllers;

use App\Http\Controllers\Controller, DB;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Http\Requests\CreatePaymentRequest;
use Bishopm\Connexion\Http\Requests\UpdatePaymentRequest;

class PaymentsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    private $individual;

    public function __construct(IndividualsRepository $individual)
    {
        $this->individual = $individual;
    }

	public function index()
	{
        $payments = DB::table('payments')->get();;
   		return view('connexion::payments.index',compact('payments'));
	}

	public function edit($payment)
    {
        $pgs=$this->individual->givingnumbers();
        $payment=DB::table('payments')->where('id','=',$payment)->first();
        return view('connexion::payments.edit', compact('payment','pgs'));
    }

    public function create()
    {
        $pgs=$this->individual->givingnumbers();
        return view('connexion::payments.create',compact('pgs'));
    }

    public function store(CreatePaymentRequest $request)
    {
        $payment = DB::table('payments')->insert(['pgnumber' => $request->input('pgnumber'), 'amount' => $request->input('amount'), 'paymentdate' => $request->input('paymentdate')]);
        return redirect()->route('admin.payments.index')
            ->withSuccess('New payment added');
    }
	
    public function update($payment, UpdatePaymentRequest $request)
    {
        $payment = DB::table('payments')->where('id', $payment)->update(['pgnumber' => $request->input('pgnumber'), 'amount' => $request->input('amount'), 'paymentdate' => $request->input('paymentdate')]);
        return redirect()->route('admin.payments.index')->withSuccess('Payment has been updated');
    }

}