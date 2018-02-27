<?php

namespace Bishopm\Connexion\Http\Controllers;

use App\Http\Controllers\Controller;

class TemplatesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $data = array();
        $blocks=scandir(base_path() . '/resources/views/vendor/bishopm/blocks');
        foreach ($blocks as $block) {
            if (strpos($block, '.blade.php')!==false) {
                $data['blocks'][]=str_replace('.blade.php', '', $block);
            }
        }
        $pages=scandir(base_path() . '/resources/views/vendor/bishopm/pages');
        foreach ($pages as $page) {
            if (strpos($page, '.blade.php')!==false) {
                $data['pages'][]=str_replace('.blade.php', '', $page);
            }
        }
        return view('connexion::filetemplates.index', $data);
    }

    public function update(Template $template, UpdateTemplateRequest $request)
    {
        $request->request->add(['created_at' => $request->input('created_at') . "12:00:00"]);
        $this->template->update($template, $request->all());
        return redirect()->route('admin.template.index')->withSuccess('Template has been updated');
    }
}
