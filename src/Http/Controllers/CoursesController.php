<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\CoursesRepository;
use Bishopm\Connexion\Repositories\UsersRepository;
use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Models\Course;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateCourseRequest;
use Bishopm\Connexion\Http\Requests\UpdateCourseRequest;
use Bishopm\Connexion\Http\Requests\CreateCommentRequest;
use Illuminate\Http\Request;

class CoursesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $course, $user, $group, $individual;

	public function __construct(CoursesRepository $course, UsersRepository $user, GroupsRepository $group, IndividualsRepository $individual)
    {
        $this->course = $course;
        $this->user = $user;
        $this->group = $group;
        $this->individual = $individual;
    }

	public function index()
	{
        $courses = $this->course->all();
   		return view('connexion::courses.index',compact('courses'));
	}

	public function edit(Course $course)
    {
        $groups=$this->group->allPublished();
        return view('connexion::courses.edit', compact('course','groups'));
    }

    public function create()
    {
        $groups=$this->group->allPublished();
        return view('connexion::courses.create',compact('groups'));
    }

	public function show($slug)
	{
        $data['course']=$this->course->findBySlug($slug);
        $data['comments'] = $data['course']->comments()->paginate(5);
        return view('connexion::site.course',$data);
	}

    public function signup($slug)
    {
        $course=$this->course->findBySlug($slug);
        $group=$this->group->find($course->id);
        $leader = $this->individual->find($group->leader);
        return view('connexion::site.coursesignup',compact('course','group','leader'));
    }

    public function store(CreateCourseRequest $request)
    {
        $course=$this->course->create($request->all());
        return redirect()->route('admin.courses.index')
            ->withSuccess('New course added');
    }
	
    public function update(Course $course, UpdateCourseRequest $request)
    {
        $this->course->update($course, $request->all());   
        return redirect()->route('admin.courses.index')->withSuccess('Course has been updated');
    }

    public function addcomment(Course $course, CreateCommentRequest $request)
    {
        $user=$this->user->find($request->user);
        $user->comment($course, $request->newcomment, $request->rating);
    }

}