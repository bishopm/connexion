<?php

namespace Bishopm\Connexion\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use LithiumDev\TagCloud\TagCloud;
use Illuminate\Support\Facades\Validator;
use Bishopm\Connexion\Repositories\PagesRepository;
use Bishopm\Connexion\Repositories\SeriesRepository;
use Bishopm\Connexion\Repositories\SlideshowsRepository;
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
use Bishopm\Connexion\Repositories\PaymentsRepository;
use Bishopm\Connexion\Models\Book;
use Bishopm\Connexion\Models\Blog;
use Bishopm\Connexion\Models\Society;
use Bishopm\Connexion\Models\Sermon;
use Bishopm\Connexion\Models\Specialday;
use Bishopm\Connexion\Models\Household;
use Bishopm\Connexion\Models\Individual;
use Bishopm\Connexion\Models\User;
use Actuallymab\LaravelComment\Models\Comment;
use Spatie\GoogleCalendar\Event;
use Auth, Feed, App;
use MediaUploader;
use Bishopm\Connexion\Notifications\SendMessage;
use Bishopm\Connexion\Notifications\CheckUserRegistration;
use Bishopm\Connexion\Http\Requests\NewUserRequest;

class WebController extends Controller
{
    
    private $page, $slideshow, $settings, $users, $series, $sermon, $individual, $courses, $group, $comments, $books, $blogs, $payments;

    public function __construct(PagesRepository $page, SlideshowsRepository $slideshow, SettingsRepository $settings, UsersRepository $users, SeriesRepository $series, SermonsRepository $sermon, IndividualsRepository $individual, CoursesRepository $courses, GroupsRepository $group, HouseholdsRepository $household, BooksRepository $books, BlogsRepository $blogs, PaymentsRepository $payments)
    {
        $this->page = $page;
        $this->group = $group;
        $this->slideshow = $slideshow;
        $this->settings = $settings;
        $this->users = $users;
        $this->series = $series;
        $this->sermon = $sermon;
        $this->individual = $individual;
        $this->courses = $courses;
        $this->books = $books;
        $this->household = $household;
        $this->blogs = $blogs;
        $this->payments = $payments;
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
        $data['blogs']=$blogs->mostRecent(6);
        $data['sermon']=$sermon->mostRecent();
        $data['slideshow']=$this->slideshow->byName('front');
        if (Auth::user()){
            $data['comments']=Comment::orderBy('created_at','DESC')->get()->take(10);
            $data['users']=$this->users->mostRecent(5);
        } 
        return view('connexion::home',$data);
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
        $cloud->setOrder('tag','ASC');
        $cloud->setHtmlizeTagFunction(function($tag, $size) use ($baseUrl) {
          $link = '<a href="'.$baseUrl.'/subject/'.$tag['url'].'">'.$tag['tag'].'</a>';
          return "<span class='tag size{$size}'>{$link}</span> ";
        });
        return view('connexion::site.blog',compact('blog','comments','media','cloud'));
    }

    public function webblogs()
    {
        $blogs = $this->blogs->allPublished();
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
        return view('connexion::site.blogs',compact('blogs','cloud'));
    }

    public function webperson($slug, IndividualsRepository $individual)
    {
        $person = $individual->findBySlug($slug);
        $staff=false;
        foreach ($person->tags as $tag){
            if ($tag->name=="staff"){
                $staff=true;
            }
        }
        return view('connexion::site.person',compact('person','staff'));
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
        $series = $this->series->allwithsermons();
        return view('connexion::site.sermons',compact('series'));
    }

    public function webgroup($slug)
    {
        $group = $this->group->findBySlug($slug);
        $signup = $this->courses->getByAttributes(array('group_id'=>$group->id));
        $leader = $this->individual->find($group->leader);
        if ((count($signup)) and (Auth::check())){
            foreach ($group->individuals as $indiv){
                if ($indiv->id == Auth::user()->individual->id){
                    $signup=array();
                }
            }
        } else {
            $signup=array();
        }
        return view('connexion::site.group',compact('group','signup','leader'));
    }    

    public function webgroupedit($slug)
    {
        $group = $this->group->findBySlug($slug);
        if (Auth::user()->individual->id==$group->leader){
            $leader = $this->individual->find($group->leader);
            $individuals = $this->individual->all();
            $indivs = $this->individual->all();
            return view('connexion::site.groupedit',compact('group','leader','indivs','individuals'));
        } else {
            return redirect()->route('webgroup',$group->slug);
        }
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
        $blogs=Blog::withTag('home-groups, small-groups')->orderBy('created_at','DESC')->get()->take(10);
        return view('connexion::site.allgroups',compact('groups','blogs'));
    } 

    public function webgroupcategory($category)
    {
        $groups = $this->group->getByAttributes(array('grouptype'=>$category));
        return view('connexion::site.groupcategory',compact('groups'));
    } 

    public function webuser($slug)
    {
        $individual = $this->individual->findBySlug($slug);
        $user = $this->users->getuserbyindiv($individual->id);
        $staff=0;
        if ($user){
            $comments = $user->comments()->paginate(10);            
            foreach ($individual->tags as $tag){
                if ($tag->slug=="staff"){
                    $staff=1;
                }
            }            
        } else {
            $comments="";
        }
        return view('connexion::site.user',compact('user','staff','comments'));
    }

    public function usermessage($id, Request $request){
        $user = $this->users->find($id);
        $user->notify(new SendMessage($request->input('message'),Auth::user()->individual));
        return redirect()->route('webuser',$user->individual->slug);
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
        $users=$this->users->allVerified();
        $society=Society::where('society',$this->settingsarray['society_name'])->first();
        foreach ($society->services as $service){
            $serviceids[]=$service->id;
        }
        foreach ($users as $user){
            if (isset($user->individual)){
                $user->status=$user->individual->service_id;
                foreach ($user->individual->tags as $tag){
                    if (strtolower($tag->slug)=="minister"){
                        $user->status="999999, " . implode(', ',$serviceids);
                    } elseif (strtolower($tag->slug)=="staff"){
                        $user->status="999999, " . $user->status;
                    }
                }
            }
        }
        return view('connexion::site.mychurch',compact('users'));
    }    

    public function mydetails()
    {
        $user=Auth::user();
        if (($user) and (isset($user->individual))){
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

    public function mygiving()
    {
        if (Auth::check()){
            $individual=Auth::user()->individual;
            $payments=$this->payments->byPG($individual->giving);
            return view('connexion::site.mygiving',compact('individual','payments'));
        } else {
            return view('connexion::site.mygiving');
        }
    }

    public function uri($slug)
    {
        $data['page'] = $this->page->findBySlug($slug);
        if ($data['page']){
            $template = $data['page']->template;
            $tags=$data['page']->tags;
            $alltags=array();
            foreach ($tags as $tag){
                $alltags[]=$tag->name;
            }
            if (count($alltags)){
                $data['blogs']=Blog::withTag($alltags)->orderBy('created_at','DESC')->get()->take(10);
            } else {
                $data['blogs']=array();
            }
            return view('connexion::templates.' . $template, $data);
        } else {
            return redirect()->route('homepage');
        }
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

    public function addimage(Request $request){
        if ($request->file('uploadfile')){
            $fullname=strval(time()) . "." . $request->file('uploadfile')->getClientOriginalExtension();
            $request->file('uploadfile')->move(base_path() . '/storage/app/public/' . $request->input('folder'),$fullname);
            return $fullname;
        }       
    }

    public function registeruser(){
        if ($this->settingsarray['society_name']){
            $society=Society::with('services')->where('society','=',$this->settingsarray['society_name'])->get();
        } else {
            $society=Society::with('services')->get();
        }
        return view('connexion::site.registeruser',compact('society'));
    }

    public function newuser(NewUserRequest $request){
        $household=new Household();
        $household->addressee = $request->input('title') . " " . $request->input('firstname') . " " . $request->input('surname');
        $household->save();

        $individual = new Individual();
        $individual->title=$request->input('title');
        $individual->firstname=$request->input('firstname');
        $individual->surname=$request->input('surname');
        $individual->cellphone=$request->input('cellphone');
        $individual->email=$request->input('email');
        $individual->service_id=$request->input('service_id');
        $individual->sex=$request->input('sex');
        $individual->household_id=$household->id;
        $individual->save();

        $household->sortsurname=$individual->surname;
        $household->householdcell=$individual->id;
        $household->save();
        $household->delete();
        
        $user=new User();
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->individual_id=$individual->id;
        $user->password=bcrypt($request->input('password'));
        $user->save();
        $user->delete();
        
        $message=$individual->firstname . " " . $individual->surname . " has created a temporary user on the " . $this->settingsarray['site_abbreviation'] . " website. You can now go to the site and activate this user.";
        $admin=User::find(1);
        $admin->notify(new CheckUserRegistration($message));

        return redirect()->route('homepage')->with('success', 'Your user has been created. We will email you and let you know when it has been activated.');
    }

    public function checkname($username){
        $user=$this->users->getByAttributes(array('name'=>$username));
        if (count($user)){
            return "error";
        } else {
            return "ok";
        }
    }

    public function updateimage(Request $request,$entity,$id='') 
    {
        $fn=strval(time()) . '.' . explode('.',$request->input('filename'))[1];
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->input('base64data')));
        if ($entity=="individuals"){
            $indiv=$this->individual->find($id);
            $file=base_path() . "/storage/app/public/individuals/" . $indiv->id . "/" . $fn;
            $url=url('/') . "/public/storage/individuals/" . $indiv->id . '/' . $fn;
        } elseif ($entity=="books") {
            $book=$this->books->find($id);
            $file=base_path() . "/storage/app/public/books/" . $fn;
            $url=url('/') . "/public/storage/books/" . $fn;
        } elseif ($entity=="courses"){
            $course=$this->courses->find($id);
            $file=base_path() . "/storage/app/public/courses/" . $fn;
            $url=url('/') . "/public/storage/courses/" . $fn;
        }
        file_put_contents($file,$data);
        return $url;
    }

    public function search(Request $request)
    {
        $q=$request->input('q');
        $individuals=Individual::where('surname','like','%' . $q . '%')->orwhere('firstname','like','%' . $q . '%')->get();
        $thislink="";
        foreach ($individuals as $indiv){
            $thislink.="<a href=\"\">" . $indiv->firstname . " " . $indiv->surname . "</a><br>";
        }
        return json_encode($thislink);
    }

    public function feed()
    {
        $feed = App::make("feed");
        // cache the feed for 60 minutes (second parameter is optional)
        $feed->setCache(0, $this->settingsarray['site_abbreviation'] . 'Feed');
        // check if there is cached feed and build new only if is not
        if (!$feed->isCached()){
            // creating rss feed with our most recent 20 posts
            $blogs = Blog::where('created_at','>','2016-02-13')->orderBy('created_at', 'desc')->take(20)->get();
            $sermons = Sermon::where('servicedate','>','2016-02-13')->orderBy('servicedate','desc')->orderBy('created_at', 'desc')->take(20)->get();
            // set your feed's title, description, link, pubdate and language
            $feed->title = $this->settingsarray['site_name'];
            $feed->description = 'A worshiping community, making disciples of Jesus to change our world';
            $feed->logo = 'http://umc.org.za/public/vendor/bishopm/images/logo.jpg';
            $feed->link = url('feed');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            $feed->pubdate = date('d-m-Y');
            $feed->lang = 'en';
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(120); // maximum length of description text
            $feeddata=array();
            foreach ($blogs as $blog){
                // set item's title, author, url, pubdate, description and content
                if ($blog->individual->image) {
                    $imgurl=url('/') . "/public/storage/individuals/" . $blog->individual_id . "/" . $blog->individual->image;
                } else {
                    $imgurl=$feed->logo;
                }
                $fulldescrip=strip_tags($blog->body);
                $dum['title']=$blog->title;
                $dum['author']=$imgurl;
                $dum['link']=url('/blog/' . $blog->slug);
                $dum['pubdate']=$blog->created_at;
                $dum['summary']="A new blog post has been published on our site.";
                $dum['content']=$fulldescrip;
                $feeddata[]=$dum;
            }
            foreach ($sermons as $sermon){
                // set item's title, author, url, pubdate, description and content
                $seriesimage=url('/') . "/public/storage/series/" . $sermon->series->image;
                $preacher=$sermon->individual->firstname . " " . $sermon->individual->surname;
                $fulldescrip="Recording of a sermon preached by " . $preacher . " at " . $this->settingsarray['site_name'] . ' on ' . date("l j F Y",strtotime($sermon->servicedate)) . '. Bible readings: ' . $sermon->readings;
                $dum['title']=$sermon->sermon;
                $dum['author']=$seriesimage;
                $dum['link']=url('/sermons/' . $sermon->series->slug . '/' . $sermon->slug);
                $dum['pubdate']=$sermon->servicedate . " 12:00:00";
                $dum['summary']="A new sermon has been uploaded to our site.";
                $dum['content']=$fulldescrip;
                $feeddata[]=$dum;
            }
            usort($feeddata, function ($a, $b) {
                return strcmp($b["pubdate"], $a["pubdate"]);
            });
        }
        foreach ($feeddata as $fd){
            $feed->add($fd['title'],$fd['author'],$fd['link'],$fd['pubdate'],$fd['summary'],$fd['content']);
        }
        return $feed->render('atom');
    }

}
