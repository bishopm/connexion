<?php

namespace Bishopm\Connexion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Repositories\PagesRepository;
use Bishopm\Connexion\Repositories\SeriesRepository;
use Bishopm\Connexion\Repositories\SlidesRepository;
use Bishopm\Connexion\Repositories\SermonsRepository;
use Bishopm\Connexion\Repositories\BlogsRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\HouseholdsRepository;
use Bishopm\Connexion\Repositories\ActionsRepository;
use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Repositories\UsersRepository;
use Bishopm\Connexion\Repositories\ResourcesRepository;
use Bishopm\Connexion\Models\Blog;
use Bishopm\Connexion\Models\Sermon;
use Spatie\GoogleCalendar\Event;
use Auth;

class WebController extends Controller
{
    
    private $page, $slides, $settings, $users, $series, $sermon, $individual, $resources, $group, $comments;

    public function __construct(PagesRepository $page, SlidesRepository $slides, SettingsRepository $settings, UsersRepository $users, SeriesRepository $series, SermonsRepository $sermon, IndividualsRepository $individual, ResourcesRepository $resources, GroupsRepository $group, HouseholdsRepository $household)
    {
        $this->page = $page;
        $this->group = $group;
        $this->slides = $slides;
        $this->settings = $settings;
        $this->users = $users;
        $this->series = $series;
        $this->sermon = $sermon;
        $this->individual = $individual;
        $this->resources = $resources;
        $this->household = $household;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(ActionsRepository $actions)
    {
        $user=Auth::user();
        $settingsarray=$this->settings->makearray();
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
        return view('connexion::dashboard',$data);
    }

    public function home(SermonsRepository $sermon, BlogsRepository $blogs)
    {
        $settingsarray=$this->settings->makearray();
        $cals=Event::get(null,null,[],$settingsarray['google_calendar'])->take(3); 
        foreach ($cals as $cal){
            $cdum['title']=$cal->summary;
            $cdum['start']=$cal->start->dateTime;
            $cdum['description']=$cal->location . ": " . $cal->description;
            if (strlen($cdum['description'])<3){
                $cdum['description']="";
            }
            if (!$cdum['start']){
                $cdum['start']=$cal->start->date;
                $cdum['stime']="";
            } else {
                $cdum['stime']=date("G:i",strtotime($cdum['start']));
            }            
            $data['cals'][]=$cdum;
        }
        $data['blogs']=$blogs->mostRecent(5);
        $data['sermon']=$sermon->mostRecent();
        $data['slides']=$this->slides->getSlideshow('front');
        return view('connexion::site.home',$data);
    }

    public function webblog($slug, BlogsRepository $blogs)
    {
        $blog = $blogs->findBySlug($slug);
        return view('connexion::site.blog',compact('blog'));
    }

    public function webperson($slug, IndividualsRepository $individual)
    {
        $person = $individual->findBySlug($slug);
        return view('connexion::site.person',compact('person'));
    }    

    public function websubject($tag)
    {
        $blogs = Blog::withTag($tag)->get();
        $sermons = Sermon::withTag($tag)->get();
        return view('connexion::site.subject',compact('blogs','sermons','tag'));
    }

    public function webseries($series)
    {
        $series = $this->series->findBySlug($series);
        return view('connexion::site.series',compact('series'));
    }

    public function websermon($series,$sermon)
    {
        $series = $this->series->findBySlug($series);
        $sermon = $this->sermon->findBySlug($sermon);
        return view('connexion::site.sermon',compact('series','sermon'));
    }

    public function websermons()
    {
        $series = $this->series->all();
        return view('connexion::site.sermons',compact('series'));
    }

    public function webgroup($slug)
    {
        $group = $this->group->findBySlug($slug);
        return view('connexion::site.group',compact('group'));
    }    

    public function webuser($slug)
    {
        $individual = $this->individual->findBySlug($slug);
        $user = $this->users->getuserbyindiv($individual->id);
        return view('connexion::site.user',compact('user'));
    }    

    public function webcourses()
    {
        $data['courses'] = $this->resources->getcourses('course');
        $data['homegroup'] = $this->resources->getcourses('home group');
        $data['selfstudy'] = $this->resources->getcourses('self-study');
        return view('connexion::site.courses',$data);
    }        

    public function mychurch()
    {
        $users=$this->users->all();
        foreach ($users as $user){
            $user->status="1";
            foreach ($user->individual->tags as $tag){
                if (strtolower($tag->slug)=="staff"){
                    $user->status="2";
                }
            }
        }
        return view('connexion::site.mychurch',compact('users'));
    }    

    public function mydetails()
    {
        $user=Auth::user();
        $indiv=$this->individual->find($user->individual_id);
        $household=$this->household->find($indiv->household_id);
        return view('connexion::site.mydetails',compact('household'));
    }        

    public function uri($slug)
    {
        $data['page'] = $this->page->findBySlug($slug);
        $template = $data['page']->template;
        return view('connexion::templates.' . $template, $data);
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
