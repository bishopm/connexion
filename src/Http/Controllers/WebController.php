<?php

namespace bishopm\base\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use bishopm\base\Repositories\PagesRepository;
use bishopm\base\Repositories\SlidesRepository;
use bishopm\base\Repositories\SermonsRepository;
use bishopm\base\Repositories\BlogsRepository;
use bishopm\base\Repositories\IndividualsRepository;
use bishopm\base\Repositories\ActionsRepository;
use bishopm\base\Models\Blog;
use bishopm\base\Models\Sermon;
use bishopm\base\Models\Setting;
use Spatie\GoogleCalendar\Event;
use Auth;

class WebController extends Controller
{
    
    private $page, $slides;

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
    public function dashboard(ActionsRepository $actions)
    {
        $user=Auth::user();
        $settings=Setting::all();
        foreach ($settings as $setting){
            $settingsarray[$setting->setting_key]=$setting->setting_value;
        }
        $data['actions']=$actions->all();
        $dum['googleCalendarId']=$settingsarray['google_calendar'];
        $dum['color']='red';
        $pcals=Event::get(null,null,[],$user->google_calendar); 
        foreach ($pcals as $pcal){
            $pdum['title']=$pcal->summary;
            $pdum['start']=$pcal->start->dateTime;
            $pdum['description']=$pcal->location . ": " . $pcal->description;
            if (strlen($pdum['description'])<3){
                $pdum['description']="";
            }
            if (!$pdum['start']){
                $pdum['start']=$pcal->start->date;
                $pdum['stime']="";
            } else {
                $pdum['stime']=date("G:i",strtotime($pdum['start']));
            }            
            $pdum['color']=$user->calendar_colour;
            $data['pcals'][]=$pdum;
        }
        $data['cals'][]=$dum;
        return view('base::dashboard',$data);
    }

    public function home(SermonsRepository $sermon, BlogsRepository $blogs)
    {
        $data['blogs']=$blogs->mostRecent(5);
        $data['sermon']=$sermon->mostRecent();
        $data['slides']=$this->slides->getSlideshow('front');
        return view('base::site.home',$data);
    }

    public function webblog($slug, BlogsRepository $blogs)
    {
        $blog = $blogs->findBySlug($slug);
        return view('base::site.blog',compact('blog'));
    }

    public function webperson($slug, IndividualsRepository $individual)
    {
        $person = $individual->findBySlug($slug);
        return view('base::site.person',compact('person'));
    }    

    public function websubject($tag)
    {
        $blogs = Blog::withTag($tag)->get();
        $sermons = Sermon::withTag($tag)->get();
        return view('base::site.subject',compact('blogs','sermons','tag'));
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
