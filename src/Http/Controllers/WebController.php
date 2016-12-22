<?php

namespace bishopm\base\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use bishopm\base\Repositories\PagesRepository;
use bishopm\base\Repositories\SlidesRepository;
use bishopm\base\Repositories\SermonsRepository;

class WebController extends Controller
{
    
    private $page,$slides;

    public function __construct(PagesRepository $page, SlidesRepository $slides)
    {
        $this->page = $page;
        $this->slides = $slides;
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

    public function home(SermonsRepository $sermon)
    {
        $data['sermon']=$sermon->mostRecent();
        $data['slides']=$this->slides->getSlideshow('front');
        return view('base::site.home',$data);
    }

    public function uri($slug)
    {
        $data['page'] = $this->page->findBySlug($slug);
        $template = $data['page']->template;
        return view('base::templates.' . $template, $data);
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
