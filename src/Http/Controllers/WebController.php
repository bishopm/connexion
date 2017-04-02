<?php

namespace Bishopm\Connexion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use LithiumDev\TagCloud\TagCloud;
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
use Bishopm\Connexion\Repositories\CoursesRepository;
use Bishopm\Connexion\Repositories\BooksRepository;
use Bishopm\Connexion\Models\Book;
use Bishopm\Connexion\Models\Blog;
use Bishopm\Connexion\Models\Society;
use Bishopm\Connexion\Models\Sermon;
use Bishopm\Connexion\Models\Specialday;
use Actuallymab\LaravelComment\Models\Comment;
use Spatie\GoogleCalendar\Event;
use Auth;

class WebController extends Controller
{
    
    private $page, $slides, $settings, $users, $series, $sermon, $individual, $courses, $group, $comments, $books;

    public function __construct(PagesRepository $page, SlidesRepository $slides, SettingsRepository $settings, UsersRepository $users, SeriesRepository $series, SermonsRepository $sermon, IndividualsRepository $individual, CoursesRepository $courses, GroupsRepository $group, HouseholdsRepository $household, BooksRepository $books)
    {
        $this->page = $page;
        $this->group = $group;
        $this->slides = $slides;
        $this->settings = $settings;
        $this->users = $users;
        $this->series = $series;
        $this->sermon = $sermon;
        $this->individual = $individual;
        $this->courses = $courses;
        $this->books = $books;
        $this->household = $household;
        $this->settingsarray=$this->settings->makearray();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(ActionsRepository $actions)
    {
        $user=Auth::user();
        //$settingsarray=$this->settings->makearray();
        $data['actions']=$actions->all();
        $dum['googleCalendarId']=$this->settingsarray['google_calendar'];
        $dum['color']='red';
        //$pcals=Event::get(null,null,[],$user->google_calendar); 
        /*foreach ($pcals as $pcal){
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
        $data['cals'][]=$dum;*/
        $data['pcals']=array();
        $data['cals']=array();
        return view('connexion::dashboard',$data);
    }

    public function home(SermonsRepository $sermon, BlogsRepository $blogs)
    {
        /*$cals=Event::get(null,null,[],$this->settingsarray['google_calendar'])->take(3); 
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
        }*/
        $data['cals']=array();
        $data['blogs']=$blogs->mostRecent(5);
        $data['sermon']=$sermon->mostRecent();
        $data['slides']=$this->slides->getSlideshow('front');
        if (Auth::user()){
            $data['comments']=Comment::orderBy('created_at','DESC')->get()->take(10);
            $data['users']=$this->users->mostRecent(5);
        } 
        return view('connexion::site.home',$data);
    }

    public function webblog($slug, BlogsRepository $blogs)
    {
        $blog = $blogs->findBySlug($slug);
        $comments = $blog->comments()->paginate(5);
        $media=$blog->getMedia('image')->first();
        $cloud = new TagCloud();
        foreach ($blogs->all() as $thisblog){
            foreach ($thisblog->tags as $tag){
                $cloud->addTag($tag->name);
                $cloud->addTag(array('tag' => $tag->name, 'url' => $tag->slug));
            }
        }
        $baseUrl=url('/');
        $cloud->setHtmlizeTagFunction(function($tag, $size) use ($baseUrl) {
          $link = '<a href="'.$baseUrl.'/subject/'.$tag['url'].'">'.$tag['tag'].'</a>';
          return "<span class='tag size{$size}'>{$link}</span> ";
        });
        return view('connexion::site.blog',compact('blog','comments','media','cloud'));
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
        $books = Book::withTag($tag)->get();
        return view('connexion::site.subject',compact('blogs','sermons','tag','books'));
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
        $comments = $sermon->comments()->paginate(5);
        return view('connexion::site.sermon',compact('series','sermon','comments'));
    }

    public function websermons()
    {
        $series = $this->series->all();
        return view('connexion::site.sermons',compact('series'));
    }

    public function webgroup($slug)
    {
        $group = $this->group->findBySlug($slug);
        $signup = $this->courses->getByAttributes(array('group_id'=>$group->id));
        return view('connexion::site.group',compact('group','signup'));
    }    

    public function weballgroups()
    {
        $data = $this->group->getByAttributes(array('publish'=>'1'));
        foreach($data as $group){
            if ($group->subcategory){
                $groups[$group->subcategory][]=$group;
            } else {
                $groups['ZZZZ'][]=$group;
            }
        }
        if (isset($groups)) {
            ksort($groups);
        } else {
            $groups=array();
        }
        return view('connexion::site.allgroups',compact('groups'));
    } 

    public function webgroupcategory($category)
    {
        $groups = $this->group->getByAttributes(array('grouptype'=>$category));
        dd($groups);
        return view('connexion::site.groupcategory',compact('groups'));
    } 

    public function webuser($slug)
    {
        $individual = $this->individual->findBySlug($slug);
        $user = $this->users->getuserbyindiv($individual->id);
        $comments = $user->comments()->paginate(10);
        $staff=0;
        foreach ($individual->tags as $tag){
            if ($tag->slug=="staff"){
                $staff=1;
            }
        }
        return view('connexion::site.user',compact('user','staff','comments'));
    }

    public function webuseredit($slug)
    {
        $individual = $this->individual->findBySlug($slug);
        if ($this->settingsarray['society_name']){
            $society=Society::with('services')->where('society','=',$this->settingsarray['society_name'])->get();
        } else {
            $society=Society::with('services')->get();
        }
        return view('connexion::site.editprofile',compact('individual','society'));
    }        

    public function webuserhouseholdedit()
    {
        $household=Auth::user()->individual->household;
        foreach ($household->individuals as $indiv){
            if (strlen($indiv->cellphone)==10){
                $cellphones[$indiv->id]['name']=$indiv->firstname;
            }
        }
        return view('connexion::site.edithousehold',compact('household','cellphones'));
    }  

    public function webuserindividualedit($slug)
    {
        $individual = $this->individual->findBySlug($slug);
        $media="webpage";
        return view('connexion::site.editindividual',compact('individual','media'));
    } 

    public function webuserindividualadd()
    {
        $household=Auth::user()->individual->household;
        $media="webpage";
        return view('connexion::site.addindividual',compact('household','media'));
    } 

    public function webuseranniversaryedit($ann)
    {
        $special = Specialday::find($ann);
        return view('connexion::site.editanniversary',compact('special'));
    } 

    public function webuseranniversaryadd()
    {
        $household = Auth::user()->individual->household;
        return view('connexion::site.addanniversary',compact('household'));
    } 

    public function webcourses()
    {
        $data['courses'] = $this->courses->getcourses('course');
        $data['homegroup'] = $this->courses->getcourses('home group');
        $data['selfstudy'] = $this->courses->getcourses('self-study');
        return view('connexion::site.courses',$data);
    }        

    public function webbooks()
    {
        $books = $this->books->all();
        return view('connexion::site.books',compact('books'));
    }

    public function mychurch()
    {
        $users=$this->users->all();
        foreach ($users as $user){
            $user->status=$user->individual->service_id;
            foreach ($user->individual->tags as $tag){
                if (strtolower($tag->slug)=="staff"){
                    $user->status="999999, " . $user->status;
                }
            }
        }
        return view('connexion::site.mychurch',compact('users'));
    }    

    public function mydetails()
    {
        $user=Auth::user();
        if ($user){
            $indiv=$this->individual->find($user->individual_id);
            $household=$this->household->find($indiv->household_id);
            $householdpgs=array();
            foreach ($household->individuals as $ii){
                if ($ii->giving){
                    $householdpgs[]=$ii->giving;
                }
            }
            $householdpgs=array_unique($householdpgs);
            asort($householdpgs);
            $cellmember=$this->individual->find($household->householdcell);
            $household->cellmember = $cellmember->firstname;
            $giving=$this->individual->givingnumbers();
            $pg=array();
            $ndx=1;
            while (count($pg)<20){
                if (!in_array($ndx,$giving)){
                    $pg[]=$ndx;
                }
                $ndx++;
            }
            return view('connexion::site.mydetails',compact('household','pg','householdpgs'));
        } else {
            return view('connexion::site.mydetails');
        }
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
