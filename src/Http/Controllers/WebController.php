<?php

namespace bishopm\base\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use bishopm\base\Repositories\PagesRepository;

class WebController extends Controller
{
    
    private $page;

    public function __construct(PagesRepository $page)
    {
        $this->page = $page;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('base::dashboard');
    }

    public function uri($slug)
    {
        $page = $this->page->findBySlug($slug);
        $template = $page->template;
        return view('base::templates.' . $template, compact('page'));
    }

    /**
     * Throw a 404 error page if the given page is not found
     * @param $page
     */
    private function throw404IfNotFound($page)
    {
        if (is_null($page)) {
            $this->app->abort('404');
        }
    }

}
