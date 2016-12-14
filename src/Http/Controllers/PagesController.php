<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\PagesRepository;
use bishopm\base\Models\Page;
use App\Http\Controllers\Controller;
use Spatie\Tags\Tag;
use bishopm\base\Http\Requests\CreatePageRequest;
use bishopm\base\Http\Requests\UpdatePageRequest;

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
   		return view('base::pages.index',$data);
	}

	public function edit(Page $page)
    {
        $templates = $this->get_templates();
        return view('base::pages.edit', compact('page','templates'));
    }

    public function create()
    {
        $templates = $this->get_templates();
        return view('base::pages.create',compact('templates'));
    }

    public function store(CreatePageRequest $request)
    {
        $this->page->create($request->all());

        return redirect()->route('admin.pages.index')
            ->withSuccess('New page added');
    }

    public function update(Page $page, UpdatePageRequest $request)
    {
        $this->page->update($page, $request->all());
        return redirect()->route('admin.pages.index')->withSuccess('Page has been updated');
    }

    private function get_templates()
    {
        $temps=scandir(base_path() . "/vendor/bishopm/base/src/Resources/views/templates");
        foreach ($temps as $template) {
            if (strlen($template)>2){
                $templates[]=str_replace('.blade.php','',$template);
            }
        }
        return $templates;
    }

}
