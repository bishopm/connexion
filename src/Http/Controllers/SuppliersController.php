<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SuppliersRepository;
use Bishopm\Connexion\Models\Supplier;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateSupplierRequest;
use Bishopm\Connexion\Http\Requests\UpdateSupplierRequest;

class SuppliersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $supplier;

	public function __construct(SuppliersRepository $supplier)
    {
        $this->supplier = $supplier;
    }

	public function index()
	{
        $suppliers = $this->supplier->all();
   		return view('connexion::suppliers.index',compact('suppliers'));
	}

	public function edit(Supplier $supplier)
    {
        return view('connexion::suppliers.edit', compact('supplier'));
    }

    public function create()
    {
        return view('connexion::suppliers.create');
    }

	public function show(Supplier $supplier)
	{
        $data['supplier']=$supplier;
        return view('connexion::suppliers.show',$data);
	}

    public function store(CreateSupplierRequest $request)
    {
        $this->supplier->create($request->all());

        return redirect()->route('admin.suppliers.index')
            ->withSuccess('New supplier added');
    }
	
    public function update(Supplier $supplier, UpdateSupplierRequest $request)
    {
        $this->supplier->update($supplier, $request->all());
        return redirect()->route('admin.suppliers.index')->withSuccess('Supplier has been updated');
    }

}