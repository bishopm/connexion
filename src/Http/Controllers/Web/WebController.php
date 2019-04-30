<?php

namespace Bishopm\Connexion\Http\Controllers\Web;

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
use Bishopm\Connexion\Repositories\BlocksRepository;
use Bishopm\Connexion\Models\Group;
use Bishopm\Connexion\Models\Book;
use Bishopm\Connexion\Models\Blog;
use Bishopm\Connexion\Models\Post;
use Bishopm\Connexion\Models\Sermon;
use Bishopm\Connexion\Models\Specialday;
use Bishopm\Connexion\Models\Household;
use Bishopm\Connexion\Models\Individual;
use Bishopm\Connexion\Models\User;
use BeyondCode\Comments\Comment;
use Spatie\GoogleCalendar\Event;
use Auth;
use Feed;
use App;
use MediaUploader;
use Bishopm\Connexion\Notifications\SendMessage;
use Bishopm\Connexion\Notifications\CheckUserRegistration;
use Bishopm\Connexion\Http\Requests\NewUserRequest;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class WebController extends Controller
{
    private $page;

    private $slideshow;

    private $settings;

    private $users;

    private $series;

    private $sermon;

    private $individual;

    private $courses;

    private $group;

    private $comments;

    private $books;

    private $blogs;

    private $blocks;

    private $payments;

    public function __construct(PagesRepository $page, SlideshowsRepository $slideshow, SettingsRepository $settings, UsersRepository $users, SeriesRepository $series, SermonsRepository $sermon, IndividualsRepository $individual, CoursesRepository $courses, GroupsRepository $group, HouseholdsRepository $household, BooksRepository $books, BlogsRepository $blogs, PaymentsRepository $payments, BlocksRepository $blocks)
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
        $this->blocks = $blocks;
        $this->settingsarray = $this->settings->makearray();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(ActionsRepository $actions)
    {
        $user = Auth::user();
        if ($this->settingsarray['filtered_tasks']) {
            $data['actions'] = $actions->filteredactionsforuser($this->settingsarray['filtered_tasks'], $user->individual_id);
        } else {
            $data['actions'] = $actions->individualtasks($user->individual_id);
        }
        return view('connexion::dashboard', $data);
    }

    public function home(SermonsRepository $sermon, BlogsRepository $blogs)
    {
        $rightnow = time();
        $data['events'] = Group::where('grouptype', 'event')->with('individuals')->where('publish', 1)->where('eventdatetime', '>', $rightnow)->get();
        $data['usercount'] = User::where('verified', '1')->count();
        $data['blocks'] = $this->blocks->homepage();
        $data['cals'] = array();
        if (count($data['events'])) {
            $data['blogs'] = $blogs->mostRecent(1);
        } else {
            $data['blogs'] = $blogs->mostRecent(6);
        }
        $data['sermon'] = $sermon->mostRecent();
        $data['slideshow'] = $this->slideshow->byName('front');
        if (Auth::user()) {
            $comments = Comment::orderBy('created_at', 'DESC')->get()->take(10);
            $data['users'] = $this->users->mostRecent(10);
            $forum = Post::orderBy('created_at', 'DESC')->get()->take(10);
            $contribs = array();
            foreach ($comments as $comment) {
                $contribs[strtotime($comment->created_at)] = $comment;
            }
            foreach ($forum as $foru) {
                $contribs[strtotime($foru->created_at)] = $foru;
            }
            krsort($contribs);
            $data['comments'] = array_slice($contribs, 0, 10);
        } else {
            $data['comments'] = array();
        }
        return view('connexion::home', $data);
    }

    public function webblog($yr, $mth = '', $slug = '', BlogsRepository $blogs)
    {
        $blog = $blogs->findByDateSlug($yr, $mth, $slug);
        if ($blog) {
            $comments = $blog->comments()->paginate(5);
            $media = $blog->getMedia('image')->first();
            $cloud = new TagCloud();
            foreach ($blogs->all() as $thisblog) {
                foreach ($thisblog->tags as $tag) {
                    $cloud->addTag($tag->name);
                    $cloud->addTag(array('tag' => $tag->name, 'url' => $tag->slug));
                }
            }
            $baseUrl = url('/');
            $cloud->setOrder('tag', 'ASC');
            $cloud->setHtmlizeTagFunction(function ($tag, $size) use ($baseUrl) {
                $link = '<a href="' . $baseUrl . '/subject/' . $tag['url'] . '">' . $tag['tag'] . '</a>';
                return "<span class='tag size{$size}'>{$link}</span> ";
            });
            return view('connexion::site.blog', compact('blog', 'comments', 'media', 'cloud'));
        } else {
            abort(404);
        }
    }

    public function webblogs()
    {
        $blogs = $this->blogs->allPublished();
        $cloud = new TagCloud();
        foreach ($blogs->all() as $thisblog) {
            foreach ($thisblog->tags as $tag) {
                $cloud->addTag($tag->name);
                $cloud->addTag(array('tag' => $tag->name, 'url' => $tag->slug));
            }
        }
        $baseUrl = url('/');
        $cloud->setHtmlizeTagFunction(function ($tag, $size) use ($baseUrl) {
            $link = '<a href="' . $baseUrl . '/subject/' . $tag['url'] . '">' . $tag['tag'] . '</a>';
            return "<span class='tag size{$size}'>{$link}</span> ";
        });
        return view('connexion::site.blogs', compact('blogs', 'cloud'));
    }

    public function webperson($slug, IndividualsRepository $individual)
    {
        $person = $individual->findBySlug($slug);
        if ($person) {
            $staff = false;
            foreach ($person->tags as $tag) {
                if ($tag->name == "staff") {
                    $staff = true;
                }
            }
            return view('connexion::site.person', compact('person', 'staff'));
        } else {
            abort(404);
        }
    }

    public function websubject($tag)
    {
        $cols = 0;
        $blogs = Blog::withTag($tag)->get();
        if (count($blogs)) {
            $cols++;
        }
        $sermons = Sermon::withTag($tag)->get();
        if (count($sermons)) {
            $cols++;
        }
        $books = Book::withTag($tag)->get();
        if (count($books)) {
            $cols++;
        }
        if ($cols < 2) {
            $colwidth = 12;
        } elseif ($cols < 3) {
            $colwidth = 6;
        } else {
            $colwidth = 4;
        }
        return view('connexion::site.subject', compact('blogs', 'sermons', 'tag', 'books', 'colwidth'));
    }

    public function webseries($series)
    {
        $series = $this->series->findBySlug($series);
        if ($series) {
            return view('connexion::site.series', compact('series'));
        } else {
            abort(404);
        }
    }

    public function websermon($seriesslug, $sermonslug)
    {
        $series = $this->series->findBySlug($seriesslug);
        if ($series) {
            $sermon = $this->sermon->findBySeriesAndSlug($series->id, $sermonslug);
            if ($sermon) {
                if (isset($sermon->individual)) {
                    $description = "A sermon preached on " . date('j F Y', strtotime($sermon->servicedate)) . " by " . $sermon->individual->firstname . " " . $sermon->individual->surname;
                } else {
                    $description = "A sermon preached on " . date('j F Y', strtotime($sermon->servicedate)) . " by a guest preacher.";
                }
            }
        } else {
            abort(404);
        }
        if ($sermon) {
            $comments = $sermon->comments()->paginate(5);
        } else {
            abort(404);
        }
        return view('connexion::site.sermon', compact('series', 'sermon', 'comments', 'description'));
    }

    public function websermons()
    {
        $series = $this->series->allwithsermons();
        return view('connexion::site.sermons', compact('series'));
    }

    public function webgroup($slug)
    {
        $group = $this->group->findBySlug($slug);
        if ($group) {
            $signup = $this->courses->getByAttributes(array('group_id' => $group->id));
            $leader = $this->individual->find($group->leader);
            if ((count($signup)) and (Auth::check())) {
                foreach ($group->individuals as $indiv) {
                    if ($indiv->id == Auth::user()->individual->id) {
                        $signup = array();
                    }
                }
            } else {
                $signup = array();
            }
            return view('connexion::site.group', compact('group', 'signup', 'leader'));
        } else {
            abort(404);
        }
    }

    public function webgroupedit($slug)
    {
        $group = $this->group->findBySlug($slug);
        if ($group) {
            if (Auth::user()->individual->id == $group->leader) {
                $leader = $this->individual->find($group->leader);
                $individuals = $this->individual->all();
                $indivs = $this->individual->all();
                return view('connexion::site.groupedit', compact('group', 'leader', 'indivs', 'individuals'));
            } else {
                return redirect()->route('webgroup', $group->slug);
            }
        } else {
            abort(404);
        }
    }

    public function weballgroups()
    {
        $data = $this->group->fellowship();
        foreach ($data as $group) {
            if ($group->subcategory) {
                $groups[$group->subcategory][] = $group;
            } else {
                $groups['ZZZZ'][] = $group;
            }
        }
        if (isset($groups)) {
            ksort($groups);
        } else {
            $groups = array();
        }
        $blogs = Blog::withTag('home-groups, small-groups')->orderBy('created_at', 'DESC')->get()->take(10);
        return view('connexion::site.allgroups', compact('groups', 'blogs'));
    }

    public function comingup()
    {
        $data = $this->group->futureevent();
        foreach ($data as $event) {
            if ($event->subcategory) {
                $events[$event->subcategory][] = $event;
            } else {
                $events['ZZZZ'][] = $event;
            }
        }
        if (isset($events)) {
            ksort($events);
        } else {
            $events = array();
        }
        $blogs = Blog::withTag('events')->orderBy('created_at', 'DESC')->get()->take(10);
        return view('connexion::site.comingup', compact('events', 'blogs'));
    }

    public function webevent($slug)
    {
        $event = $this->group->findBySlug($slug);
        if ($event->payment) {
            $payment = $this->settingsarray['qr_code'];
        } else {
            $payment = "";
        }
        return view('connexion::site.event', compact('event', 'payment'));
    }

    public function webgroupcategory($category)
    {
        $groups = $this->group->getByAttributes(array('grouptype' => $category));
        if ($groups) {
            return view('connexion::site.groupcategory', compact('groups'));
        } else {
            abort(404);
        }
    }

    public function webuser($slug)
    {
        $theme = $this->settingsarray['website_theme'];
        $individual = $this->individual->findBySlug($slug);
        if ($individual) {
            $user = $this->users->getuserbyindiv($individual->id);
            if ($user) {
                $staff = 0;
                if ($user) {
                    $comms = $user->comments()->paginate(10);
                    $posts = $user->posts;
                    $comments = array();
                    foreach ($comms as $comm) {
                        $comments[strtotime($comm->created_at)] = $comm;
                    }
                    foreach ($posts as $post) {
                        $comments[strtotime($post->created_at)] = $post;
                    }
                    foreach ($individual->tags as $tag) {
                        if ($tag->slug == "staff") {
                            $staff = 1;
                        }
                    }
                    krsort($comments);
                } else {
                    $comments = "";
                }
                return view('connexion::site.user', compact('user', 'staff', 'comments', 'theme'));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function usermessage($id, Request $request)
    {
        $user = $this->users->find($id);
        $user->notify(new SendMessage($request->input('message'), Auth::user()->individual));
        return redirect()->route('webuser', $user->individual->slug);
    }

    public function webuseredit($slug)
    {
        $individual = $this->individual->findBySlug($slug);
        if ($individual) {
            $services = explode(',', $this->settingsarray['worship_services']);
            return view('connexion::site.editprofile', compact('individual', 'services'));
        } else {
            abort(404);
        }
    }

    public function webuserhouseholdedit()
    {
        $household = Auth::user()->individual->household;
        foreach ($household->individuals as $indiv) {
            if (strlen($indiv->cellphone) == 10) {
                $cellphones[$indiv->id]['name'] = $indiv->firstname;
            }
        }
        return view('connexion::site.edithousehold', compact('household', 'cellphones'));
    }

    public function webuserindividualedit($slug)
    {
        $individual = $this->individual->findBySlug($slug);
        $media = "webpage";
        return view('connexion::site.editindividual', compact('individual', 'media'));
    }

    public function webuserindividualadd()
    {
        $household = Auth::user()->individual->household;
        $media = "webpage";
        return view('connexion::site.addindividual', compact('household', 'media'));
    }

    public function webuseranniversaryedit($ann)
    {
        $special = Specialday::find($ann);
        return view('connexion::site.editanniversary', compact('special'));
    }

    public function webuseranniversaryadd()
    {
        $household = Auth::user()->individual->household;
        return view('connexion::site.addanniversary', compact('household'));
    }

    public function webcourses()
    {
        $data['courses'] = $this->courses->getcourses('course');
        $data['homegroup'] = $this->courses->getcourses('home group');
        $data['selfstudy'] = $this->courses->getcourses('self-study');
        return view('connexion::site.courses', $data);
    }

    public function webbooks()
    {
        $books = $this->books->all();
        return view('connexion::site.books', compact('books'));
    }

    public function webauthor($author)
    {
        $author = urldecode($author);
        $books = Book::where('author', 'like', '%' . $author . '%')->get();
        return view('connexion::site.author', compact('author', 'books'));
    }

    public function mychurch()
    {
        $users = $this->users->allVerified();
        $services = explode(',', $this->settingsarray['worship_services']);
        foreach ($users as $user) {
            if (isset($user->individual)) {
                $user->status = $user->individual->servicetime;
                foreach ($user->individual->tags as $tag) {
                    if (strtolower($tag->slug) == "minister") {
                        $user->status = "staff " . implode(' ', $services);
                    } elseif (strtolower($tag->slug) == "staff") {
                        $user->status = "staff " . $user->status;
                    }
                }
            }
        }
        return view('connexion::site.mychurch', compact('users', 'services'));
    }

    public function mydetails()
    {
        $user = Auth::user();
        if (($user) and (isset($user->individual))) {
            $indiv = $this->individual->find($user->individual_id);
            $household = $this->household->find($indiv->household_id);
            $householdpgs = array();
            foreach ($household->individuals as $ii) {
                if ($ii->giving) {
                    $householdpgs[] = $ii->giving;
                }
            }
            $householdpgs = array_unique($householdpgs);
            asort($householdpgs);
            if ($household->householdcell) {
                $cellmember = $this->individual->find($household->householdcell);
                $household->cellmember = $cellmember->firstname;
            } else {
                $household->cellmember = "Please edit household to specify";
            }
            $giving = $this->individual->givingnumbers();
            $pg = array();
            $ndx = 1;
            while (count($pg) < 20) {
                if (!in_array($ndx, $giving)) {
                    $pg[] = $ndx;
                }
                $ndx++;
            }
            return view('connexion::site.mydetails', compact('household', 'pg', 'householdpgs'));
        } else {
            return view('connexion::site.mydetails');
        }
    }

    public function mygiving()
    {
        if (Auth::check()) {
            $individual = Auth::user()->individual;
            $payments = $this->payments->byPG($individual->giving);
            return view('connexion::site.mygiving', compact('individual', 'payments'));
        } else {
            return view('connexion::site.mygiving');
        }
    }

    public function uri($slug)
    {
        $data['page'] = $this->page->findBySlug($slug);
        if ($data['page']) {
            $data['titletagtitle'] = $data['page']->title;
            $template = $data['page']->template;
            $tags = $data['page']->tags;
            $alltags = array();
            foreach ($tags as $tag) {
                $alltags[] = $tag->name;
            }
            if (count($alltags)) {
                $data['blogs'] = Blog::withTag($alltags)->orderBy('created_at', 'DESC')->get()->take(10);
            } else {
                $data['blogs'] = array();
            }
            return view('connexion::templates.' . $template, $data);
        } else {
            abort(404);
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

    public function addimage(Request $request)
    {
        if ($request->file('uploadfile')) {
            $fullname = strval(time()) . "." . $request->file('uploadfile')->getClientOriginalExtension();
            $request->file('uploadfile')->move(base_path() . '/storage/app/public/' . $request->input('folder'), $fullname);
            return $fullname;
        }
    }

    public function registeruser()
    {
        $services = explode(',', $this->settingsarray['worship_services']);
        return view('connexion::site.registeruser', compact('services'));
    }

    public function newuser(NewUserRequest $request)
    {
        $household = new Household();
        $household->addressee = $request->input('title') . " " . $request->input('firstname') . " " . $request->input('surname');
        $household->save();

        $individual = new Individual();
        $individual->title = $request->input('title');
        $individual->firstname = $request->input('firstname');
        $individual->surname = $request->input('surname');
        $individual->cellphone = $request->input('cellphone');
        $individual->email = $request->input('email');
        $individual->servicetime = $request->input('servicetime');
        $individual->sex = $request->input('sex');
        $individual->household_id = $household->id;
        $individual->save();

        $household->sortsurname = $individual->surname;
        $household->householdcell = $individual->id;
        $household->save();
        $household->delete();

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->individual_id = $individual->id;
        $user->password = bcrypt($request->input('password'));
        $user->save();
        $user->delete();

        $message = $individual->firstname . " " . $individual->surname . " has created a temporary user on the " . $this->settingsarray['site_abbreviation'] . " website. You can now go to the site and activate this user.";
        $admin = User::find(1);
        $admin->notify(new CheckUserRegistration($message));

        return redirect()->route('homepage')->with('success', 'Your user has been created. We will email you and let you know when it has been activated.');
    }

    public function checkname($username)
    {
        $user = $this->users->getByAttributes(array('name' => $username));
        if (count($user)) {
            return "error";
        } else {
            return "ok";
        }
    }

    public function updateimage(Request $request, $entity, $id = '')
    {
        $fn = strval(time()) . '.' . explode('.', $request->input('filename'))[1];
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->input('base64data')));
        if ($entity == "individuals") {
            $indiv = $this->individual->find($id);
            $file = base_path() . "/storage/app/public/individuals/" . $indiv->id . "/" . $fn;
            $url = url('/') . "/public/storage/individuals/" . $indiv->id . '/' . $fn;
        } elseif ($entity == "books") {
            $book = $this->books->find($id);
            $file = base_path() . "/storage/app/public/books/" . $fn;
            $url = url('/') . "/public/storage/books/" . $fn;
        } elseif ($entity == "courses") {
            $course = $this->courses->find($id);
            $file = base_path() . "/storage/app/public/courses/" . $fn;
            $url = url('/') . "/public/storage/courses/" . $fn;
        } elseif ($entity == "series") {
            $series = $this->series->find($id);
            $file = base_path() . "/storage/app/public/series/" . $fn;
            $url = url('/') . "/public/storage/series/" . $fn;
        } elseif ($entity == "events") {
            $event = $this->group->find($id);
            $file = base_path() . "/storage/app/public/events/" . $fn;
            $url = url('/') . "/public/storage/events/" . $fn;
        } elseif ($entity == "slides") {
            $file = base_path() . "/storage/app/public/slides/" . $fn;
            $url = url('/') . "/public/storage/slides/" . $fn;
        }
        file_put_contents($file, $data);
        return $url;
    }

    public function search(Request $request)
    {
        $q = $request->input('q');
        $individuals = Individual::with('household')->where('surname', 'like', '%' . $q . '%')->orwhere('firstname', 'like', '%' . $q . '%')->orwhere('cellphone', 'like', '%' . $q . '%')->orderBy('surname')->orderBy('firstname')->get();
        $thislink = "<table class=\"table table-responsive table-striped table-condensed\"><th>Name</th><th>Cellphone</th><th>Email</th></tr>";
        foreach ($individuals as $indiv) {
            if ($indiv->household) {
                $thislink .= "<tr><td><a href=\"" . url('/') . "/admin/households/" . $indiv->household_id . "\">" . $indiv->surname . ", " . $indiv->firstname . "</td><td>" . $indiv->cellphone . "</td><td>" . $indiv->email . "</td></tr>";
            }
        }
        $thislink .= "</table>";
        return json_encode($thislink);
    }

    public function feed($service = "default")
    {
        $feed = App::make("feed");
        // cache the feed for 60 minutes (second parameter is optional)
        $feed->setCache(0, $this->settingsarray['site_abbreviation'] . 'Feed');
        // check if there is cached feed and build new only if is not
        if (!$feed->isCached()) {
            // creating rss feed with our most recent 20 posts
            $blogs = Blog::where('status', 'Published')->where('created_at', '>', '2019-02-10')->orderBy('created_at', 'desc')->take(20)->get();
            $sermons = Sermon::where('servicedate', '>', '2019-02-10')->where('status', 'Published')->orderBy('servicedate', 'desc')->orderBy('created_at', 'desc')->take(20)->get();
            $events = Group::where('grouptype', 'event')->where('publish', 1)->orderBy('created_at', 'desc')->take(20)->get();
            $books = Book::where('sample', '<>', '')->orderBy('created_at', 'desc')->take(20)->get();

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
            $feeddata = array();
            foreach ($blogs as $blog) {
                // set item's title, author, url, pubdate, description and content
                if ($blog->individual->image) {
                    $imgurl = url('/') . "/public/storage/individuals/" . $blog->individual_id . "/" . $blog->individual->image;
                } else {
                    $imgurl = $feed->logo;
                }
                $dum['title'] = $blog->title;
                $dum['author'] = $blog->individual->firstname . " " . $blog->individual->surname;
                $dum['link'] = url('/blog/' . date("Y", strtotime($blog->created_at)) . '/' . date("m", strtotime($blog->created_at)) . '/' . $blog->slug);
                $dum['pubdate'] = $blog->created_at;
                $dum['summary'] = "A new blog post has been published on our site.";
                if ($service == "default") {
                    $dum['content'] = "<h2><a href=\"" . $dum['link'] . "\">" . $blog->title . "</a></h2><img src=\"" . $imgurl . "\">" . $blog->body;
                } else {
                    $dum['content'] = "New blog post: " . $blog->title . " " . $dum['link'];
                }
                $feeddata[] = $dum;
            }
            foreach ($books as $book) {
                if ($book->image) {
                    $image = url('/') . "/public/storage/books/" . $book->image;
                } else {
                    $image = $feed->logo;
                }
                $dum['title'] = $book->title . " by " . $book->author;
                $dum['author'] = $this->settingsarray['site_name'];
                $dum['link'] = url('/book/' . $book->slug);
                $dum['pubdate'] = $book->created_at;
                $dum['summary'] = "Download a sample chapter of a new book available through our bookshop:";
                if ($service == "default") {
                    $dum['content'] = "<h2><a href=\"" . $dum['link'] . "\">" . $dum['title'] . "</a></h2><img src=\"" . $imgurl . "\">" . $book->description;
                } else {
                    $dum['content'] = "New book: Preview a sample from '" . $book->title . "' " . $dum['link'];
                }
                $feeddata[] = $dum;
            }
            foreach ($sermons as $sermon) {
                // set item's title, author, url, pubdate, description and content
                if ($sermon->series->image) {
                    $seriesimage = url('/') . "/public/storage/series/" . $sermon->series->image;
                } else {
                    $seriesimage = $feed->logo;
                }
                if ($sermon->individual) {
                    $preacher = $sermon->individual->firstname . " " . $sermon->individual->surname;
                } else {
                    $preacher = "guest preacher";
                }
                $fulldescrip = "Recording of a sermon preached by " . $preacher . " at " . $this->settingsarray['site_name'] . ' on ' . date("l j F Y", strtotime($sermon->servicedate)) . '. Bible readings: ' . $sermon->readings;
                $dum['title'] = $sermon->title;
                $dum['author'] = $preacher;
                $dum['link'] = url('/sermons/' . $sermon->series->slug . '/' . $sermon->slug);
                $dum['pubdate'] = $sermon->servicedate . " 12:00:00";
                $dum['summary'] = "A new sermon has been uploaded to our site.";
                if ($service == "default") {
                    $dum['content'] = "<h2><a href=\"" . $dum['link'] . "\">" . $dum['title'] . "</a></h2><img src=\"" . $seriesimage . "\">" . $fulldescrip;
                } else {
                    $dum['content'] = "New sermon: " . $sermon->title . " " . $dum['link'];
                }
                $feeddata[] = $dum;
            }
            foreach ($events as $event) {
                $dum['title'] = $event->groupname . " (" . date("d M Y H:i", $event->eventdatetime) . ")";
                if ($event->image) {
                    $imgurl = url('/') . "/public/storage/events/" . $event->image;
                } else {
                    $imgurl = url('/') . "/public/vendor/bishopm/images/signmeup.jpg";
                }
                $dum['author'] = $this->settingsarray['site_name'];
                $dum['link'] = url('/coming-up/' . $event->slug);
                $dum['pubdate'] = $event->created_at;
                $dum['summary'] = "A new event has been set up on our site.";
                if ($service == "default") {
                    $dum['content'] = $event->description;
                } else {
                    $dum['content'] = "New event at UMC: " . $event->groupname . " " . $dum['link'];
                }
                $feeddata[] = $dum;
            }

            usort($feeddata, function ($a, $b) {
                return strcmp($b["pubdate"], $a["pubdate"]);
            });
        }
        foreach ($feeddata as $fd) {
            $feed->add($fd['title'], $fd['author'], $fd['link'], $fd['pubdate'], $fd['summary'], $fd['content']);
        }
        return $feed->render('atom');
    }

    public function blogfeed()
    {
        $feed = App::make("feed");
        $feed->setCache(0, $this->settingsarray['site_abbreviation'] . 'BlogFeed');
        $lastweek = date('Y-m-d', strtotime("-1 week"));
        if (!$feed->isCached()) {
            // creating rss feed with last weeks posts
            $blogs = Blog::where('status', 'Published')->where('created_at', '>', $lastweek)->orderBy('created_at', 'desc')->get();
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
            $feeddata = array();
            foreach ($blogs as $blog) {
                // set item's title, author, url, pubdate, description and content
                if ($blog->individual->image) {
                    $imgurl = url('/') . "/storage/individuals/" . $blog->individual_id . "/" . $blog->individual->image;
                } else {
                    $imgurl = $feed->logo;
                }
                $dum['title'] = $blog->title;
                $dum['author'] = $blog->individual->firstname . " " . $blog->individual->surname;
                $dum['link'] = url('/blog/' . date("Y", strtotime($blog->created_at)) . '/' . date("m", strtotime($blog->created_at)) . '/' . $blog->slug);
                $dum['pubdate'] = $blog->created_at;
                $dum['summary'] = "blog";
                $dum['content'] = $blog->body;
                $feeddata[] = $dum;
            }
            usort($feeddata, function ($a, $b) {
                return strcmp($b["pubdate"], $a["pubdate"]);
            });
        }
        foreach ($feeddata as $fd) {
            $feed->add($fd['title'], $fd['author'], $fd['link'], $fd['pubdate'], $fd['summary'], $fd['content']);
        }
        return $feed->render('rss');
    }

    public function sermonfeed()
    {
        $feed = App::make("feed");
        $feed->setCache(0, $this->settingsarray['site_abbreviation'] . 'SermonFeed');
        $lastweek = date('Y-m-d', strtotime("-1 week"));
        if (!$feed->isCached()) {
            // creating rss feed with last weeks posts
            $sermons = Sermon::where('servicedate', '>', $lastweek)->where('status', 'Published')->orderBy('servicedate', 'desc')->orderBy('created_at', 'desc')->get();
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
            $feeddata = array();
            foreach ($sermons as $sermon) {
                // set item's title, author, url, pubdate, description and content
                if ($sermon->series->image) {
                    $seriesimage = url('/') . "/storage/series/" . $sermon->series->image;
                } else {
                    $seriesimage = $feed->logo;
                }
                if ($sermon->individual) {
                    $preacher = $sermon->individual->firstname . " " . $sermon->individual->surname;
                    $fname = $sermon->individual->firstname;
                    $sname = $sermon->individual->surname;
                } else {
                    $preacher = "guest preacher";
                }
                $enclosure = array();
                $enclosure['url'] = $sermon->mp3;
                $urldata = get_headers($sermon->mp3, true);
                $enclosure['length'] = (int)$urldata['Content-Length'];
                $enclosure['type'] = "audio/mp3";
                $fulldescrip = "Recording of a sermon preached at <b>" . $this->settingsarray['site_name'] . '</b> on ' . date("l j F Y", strtotime($sermon->servicedate)) . '.<br><b>Bible readings:</b> ' . $sermon->readings;
                $dum['title'] = $sermon->title;
                $dum['author'] = $preacher;
                $dum['link'] = $seriesimage;
                $dum['enclosure'] = $enclosure;
                $dum['pubdate'] = $sermon->servicedate . " 12:00:00";
                $dum['summary'] = "sermon";
                unset($sermon->individual->cellphone);
                unset($sermon->individual->giving);
                unset($sermon->individual->email);
                unset($sermon->individual->notes);
                unset($sermon->individual->birthdate);
                unset($sermon->individual->sex);
                unset($sermon->individual->memberstatus);
                unset($sermon->individual->servicetime);
                unset($sermon->individual->image);
                unset($sermon->individual->leadership);
                $sermon->preacher = $preacher;
                $dum['content'] = $fulldescrip;
                $feeddata[] = $dum;
            }
            usort($feeddata, function ($a, $b) {
                return strcmp($b["pubdate"], $a["pubdate"]);
            });
        }
        foreach ($feeddata as $fd) {
            $feed->add($fd['title'], $fd['author'], $fd['link'], $fd['pubdate'], $fd['summary'], $fd['content'], $fd['enclosure']);
        }
        return $feed->render('rss');
    }

    public function journeyfeed()
    {
        $feed = App::make("feed");
        $feed->setCache(0, $this->settingsarray['site_abbreviation'] . 'JourneyFeed');
        $lastweek = date('Y-m-d', strtotime("-1 week"));
        if (!$feed->isCached()) {
            // creating rss feed with last weeks posts
            $blogs = Blog::where('status', 'Published')->where('created_at', '>', $lastweek)->orderBy('created_at', 'desc')->get();
            $sermons = Sermon::where('servicedate', '>', $lastweek)->where('status', 'Published')->orderBy('servicedate', 'desc')->orderBy('created_at', 'desc')->get();
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
            $feeddata = array();
            foreach ($blogs as $blog) {
                // set item's title, author, url, pubdate, description and content
                if ($blog->individual->image) {
                    $imgurl = url('/') . "/storage/individuals/" . $blog->individual_id . "/" . $blog->individual->image;
                } else {
                    $imgurl = $feed->logo;
                }
                $dum['title'] = $blog->title;
                $dum['author'] = $blog->individual->firstname . " " . $blog->individual->surname;
                $dum['link'] = url('/blog/' . date("Y", strtotime($blog->created_at)) . '/' . date("m", strtotime($blog->created_at)) . '/' . $blog->slug);
                $dum['pubdate'] = $blog->created_at;
                $dum['summary'] = "blog";
                $dum['content'] = $blog->body;
                $feeddata[] = $dum;
            }
            foreach ($sermons as $sermon) {
                // set item's title, author, url, pubdate, description and content
                if ($sermon->series->image) {
                    $seriesimage = url('/') . "/storage/series/" . $sermon->series->image;
                } else {
                    $seriesimage = $feed->logo;
                }
                if ($sermon->individual) {
                    $preacher = $sermon->individual->firstname . " " . $sermon->individual->surname;
                    $fname = $sermon->individual->firstname;
                    $sname = $sermon->individual->surname;
                } else {
                    $preacher = "guest preacher";
                }
                $fulldescrip = "Recording of a sermon preached by " . $preacher . " at " . $this->settingsarray['site_name'] . ' on ' . date("l j F Y", strtotime($sermon->servicedate)) . '. Bible readings: ' . $sermon->readings;
                $dum['title'] = $sermon->title;
                $dum['author'] = $preacher;
                $dum['link'] = $seriesimage;
                $dum['pubdate'] = $sermon->servicedate . " 12:00:00";
                $dum['summary'] = "sermon";
                unset($sermon->individual->cellphone);
                unset($sermon->individual->giving);
                unset($sermon->individual->email);
                unset($sermon->individual->notes);
                unset($sermon->individual->birthdate);
                unset($sermon->individual->sex);
                unset($sermon->individual->memberstatus);
                unset($sermon->individual->servicetime);
                unset($sermon->individual->image);
                unset($sermon->individual->leadership);
                $sermon->preacher = $preacher;
                $dum['content'] = $fulldescrip;
                $feeddata[] = $dum;
            }
            usort($feeddata, function ($a, $b) {
                return strcmp($b["pubdate"], $a["pubdate"]);
            });
        }
        foreach ($feeddata as $fd) {
            $feed->add($fd['title'], $fd['author'], $fd['link'], $fd['pubdate'], $fd['summary'], $fd['content']);
        }
        return $feed->render('atom');
    }

    public function deletecomment(Request $request)
    {
        $comment = Comment::find($request->id);
        $comment->delete();
        return $request->id;
    }

    public function getusername($email)
    {
        $users = $this->users->getByAttributes(array('email' => $email));
        if (count($users)) {
            foreach ($users as $user) {
                $dat[] = $user->name;
            }
            return json_encode($dat);
        } else {
            return "error";
        }
    }

    public function lectionary()
    {
        $today = date('Y-m-d');
        $yesterday = date("Y-m-d", time() - 60 * 60 * 24);
        $lectionary = DB::table('readings')->where('readingdate', $today)->first();
        $readings = explode(';', strip_tags($lectionary->readings));
        $data['title'] = "Daily readings for " . date("l, j F Y") . " <small>From the <a target=\"_blank\" href=\"http://www.commontexts.org\">Revised Common Lectionary</a></small>";
        if ($lectionary->copyright) {
            $loop = 1;
            foreach ($readings as $reading) {
                $reading = trim($reading);
                $dum['reading'] = $reading;
                $varname = "reading" . $loop;
                $dum['text'] = $lectionary->$varname;
                $dum['copyright'] = $lectionary->copyright;
                $data['readings'][] = $dum;
                $loop++;
            }
        } else {
            $loop = 1;
            $api_secret = $this->settingsarray['bibles_api_key'];
            $client = new Client(['auth' => [$api_secret, '']]);
            foreach ($readings as $reading) {
                $varname = "reading" . strval($loop);
                $reading = trim($reading);
                $response = json_decode($client->request('GET', 'https://bibles.org/v2/passages.js?q[]=' . urlencode($reading) . '&version=eng-GNBDC')->getBody()->getContents(), true);
                $dum['reading'] = $reading;
                $dum['text'] = $response['response']['search']['result']['passages'][0]['text'];
                $dum['copyright'] = "Good News Bible. Scripture taken from the Good News Bible (Today's English Version Second Edition, UK/British Edition). Copyright © 1992 British & Foreign Bible Society. Used by permission. Revised Common Lectionary Daily Readings, copyright © 2005 Consultation on Common Texts. <a target=\"_blank\" href=\"http://www.commontexts.org\">www.commontexts.org</a>";
                $data['readings'][] = $dum;
                DB::table('readings')->where('id', $lectionary->id)->update([$varname => $dum['text']]);
                DB::table('readings')->where('readingdate', $yesterday)->update(['reading1' => '', 'reading2' => '', 'reading3' => '', 'reading4' => '', 'copyright' => '']);
                $loop++;
            }
            DB::table('readings')->where('id', $lectionary->id)->update(['copyright' => $dum['copyright']]);
        }
        if (\Request::route()->getName() == "lectionary") {
            return view('connexion::site.lectionary', $data);
        } else {
            $alldat = array();
            $alldat['reading'] = "<h2>Daily readings for " . date("l, j F Y") . "</h2>";
            foreach ($data['readings'] as $read) {
                $alldat['reading'] .= "<h3>" . $read['reading'] . "</h3>" . $read['text'];
            }
            $alldat['reading'] .= "<small>" . $read['copyright'] . "</small>";
            return $alldat;
        }
    }

    public function api_comments()
    {
        $comments = Comment::orderBy('created_at', 'DESC')->get()->take(10);
        foreach ($comments as $comment) {
            $comment->title = $comment->commentable->title;
            $comment->user = $comment->commented->individual->firstname . ' ' . $comment->commented->individual->surname;
            $comment->model = strtolower(substr(strrchr($comment->commentable_type, "\\"), 1));
            $comment->ago = Carbon::parse($comment->created_at)->diffForHumans();
        }
        return $comments;
    }

    public function apitag($tag)
    {
        $data['blogs'] = Blog::withTag($tag)->get();
        $data['sermons'] = Sermon::withTag($tag)->get();
        $data['books'] = Book::withTag($tag)->get();
        return $data;
    }
}
