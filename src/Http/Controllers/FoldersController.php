<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\FoldersRepository;
use bishopm\base\Models\Folder;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateFolderRequest;
use bishopm\base\Http\Requests\UpdateFolderRequest;

class FoldersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $folder;

	public function __construct(FoldersRepository $folder)
    {
        $this->folder = $folder;
    }

	public function index()
	{
        $folders = $this->folder->all();
   		return view('base::folders.index',compact('folders'));
	}

	public function edit(Folder $folder)
    {
        return view('base::folders.edit', compact('folder'));
    }

    public function create()
    {
        return view('base::folders.create');
    }

	public function show(Folder $folder)
	{
        $data['folder']=$folder;
        return view('base::folders.show',$data);
	}

    public function store(CreateFolderRequest $request)
    {
        $this->folder->create($request->all());

        return redirect()->route('admin.folders.index')
            ->withSuccess('New folder added');
    }
	
    public function update(Folder $folder, UpdateFolderRequest $request)
    {
        $this->folder->update($folder, $request->all());
        return redirect()->route('admin.folders.index')->withSuccess('Folder has been updated');
    }

}