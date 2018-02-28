<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\BlocksRepository;
use Bishopm\Connexion\Models\Block;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateBlockRequest;
use Bishopm\Connexion\Http\Requests\UpdateBlockRequest;

class BlocksController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $block;

    public function __construct(BlocksRepository $block)
    {
        $this->block = $block;
    }

    public function index()
    {
        $data['blocks'] = $this->block->all();
        return view('connexion::blocks.index', $data);
    }

    public function edit(Block $block)
    {
        $data['block'] = $block;
        $files=scandir(base_path() . '/resources/views/vendor/bishopm/blocks');
        foreach ($files as $file) {
            if (strpos($file, '.blade.php')!==false) {
                $data['files'][]=str_replace('.blade.php', '', $file);
            }
        }
        return view('connexion::blocks.edit', $data);
    }

    public function create()
    {
        $files=scandir(base_path() . '/resources/views/vendor/bishopm/blocks');
        $data['files']=array();
        foreach ($files as $file) {
            if (strpos($file, '.blade.php')!==false) {
                $data['files'][]=str_replace('.blade.php', '', $file);
            }
        }
        return view('connexion::blocks.create', $data);
    }

    public function store(CreateBlockRequest $request)
    {
        $this->block->create($request->all());
        return redirect()->route('admin.blocks.index')
            ->withSuccess('New block added');
    }

    public function update(Block $block, UpdateBlockRequest $request)
    {
        $this->block->update($block, $request->all());
        return redirect()->route('admin.blocks.index')->withSuccess('Block has been updated');
    }
}
