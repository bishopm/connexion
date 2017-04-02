<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\CoursesRepository;
use Bishopm\Connexion\Repositories\UsersRepository;
use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Models\Course;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateCourseRequest;
use Bishopm\Connexion\Http\Requests\UpdateCourseRequest;
use Bishopm\Connexion\Http\Requests\CreateCommentRequest;
use MediaUploader;

class CoursesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $course, $user, $group;

	public function __construct(CoursesRepository $course, UsersRepository $user, GroupsRepository $group)
    {
        $this->course = $course;
        $this->user = $user;
        $this->group = $group;
    }

	public function index()
	{
        $courses = $this->course->all();
   		return view('connexion::courses.index',compact('courses'));
	}

	public function edit(Course $course)
    {
        $media=$course->getMedia('image')->first();
        return view('connexion::courses.edit', compact('course','media'));
    }

    public function create()
    {
        return view('connexion::courses.create');
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
        return view('connexion::site.coursesignup',compact('course'));
    }

    public function store(CreateCourseRequest $request)
    {
        $course=$this->course->create($request->except('image'));
        if ($request->file('image')){
            $fname=$course->id;
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('courses')->useFilename($fname)->upload();
            $course->attachMedia($media, 'image');
        }
        return redirect()->route('admin.courses.index')
            ->withSuccess('New course added');
    }
	
    public function update(Course $course, UpdateCourseRequest $request)
    {
        $this->course->update($course, $request->except('image'));
        if ($request->file('image')){
            $fname=$course->id;
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('courses')->useFilename($fname)->upload();
            $course->attachMedia($media, 'image');
        }        
        return redirect()->route('admin.courses.index')->withSuccess('Course has been updated');
    }

    public function removemedia(Course $course)
    {
        $media = $course->getMedia('image');
        $course->detachMedia($media);
    }

    public function addcomment(Course $course, CreateCommentRequest $request)
    {
        $user=$this->user->find($request->user);
        $user->comment($course, $request->newcomment, $request->rating);
    }

}