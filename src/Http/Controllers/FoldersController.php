<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\FoldersRepository;
use Bishopm\Connexion\Models\Folder;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateFolderRequest;
use Bishopm\Connexion\Http\Requests\UpdateFolderRequest;

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
   		return view('connexion::folders.index',compact('folders'));
	}

	public function edit(Folder $folder)
    {
        return view('connexion::folders.edit', compact('folder'));
    }

    public function create()
    {
        return view('connexion::folders.create');
    }

	public function show(Folder $folder)
	{
        $data['folder']=$folder;
        return view('connexion::folders.show',$data);
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

    public function api_folders(){
        return $this->folders->all();
    }

}