<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\PagesRepository;
use Bishopm\Connexion\Models\Page;
use Bishopm\Connexion\Models\Blog;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreatePageRequest;
use Bishopm\Connexion\Http\Requests\UpdatePageRequest;

class PagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $page;

	public function __construct(PagesRepository $page)
    {
        $this->page = $page;
    }

	public function index()
	{
        $data['pages'] = $this->page->all();
   		return view('connexion::pages.index',$data);
	}

	public function edit(Page $page)
    {
        $tags=Blog::allTags()->get();
        $btags=array();
        foreach ($page->tags as $tag){
            $btags[]=$tag->name;
        }
        $templates = $this->get_templates();
        return view('connexion::pages.edit', compact('page','templates','tags','btags'));
    }

    public function create()
    {
        $tags=Blog::allTags()->get();
        $templates = $this->get_templates();
        return view('connexion::pages.create',compact('templates','tags'));
    }

    public function store(CreatePageRequest $request)
    {
        $page=$this->page->create($request->except('files','tags'));
        $page->tag($request->tags);
        return redirect()->route('admin.pages.index')
            ->withSuccess('New page added');
    }

    public function update(Page $page, UpdatePageRequest $request)
    {
        $page=$this->page->update($page, $request->except('files','tags'));
        $page->tag($request->tags);
        return redirect()->route('admin.pages.index')->withSuccess('Page has been updated');
    }

    private function get_templates()
    {
        $temps=scandir(base_path() . "/vendor/bishopm/connexion/src/Resources/views/templates");
        foreach ($temps as $template) {
            if (strlen($template)>2){
                $templates[]=str_replace('.blade.php','',$template);
            }
        }
        return $templates;
    }

}
