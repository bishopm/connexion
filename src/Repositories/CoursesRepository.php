<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class CoursesRepository extends EloquentBaseRepository
{
	public function getcourses($coursetype){
        return $this->model->where('category',$coursetype)->get();
    }

    public function allForApi(){
        return $this->model->OrderBy('title')->get();
    }

    public function findForApi($id){
        $course = $this->model::with('comments')->where('id',$id)->first();
        foreach ($course->comments as $comment){
            $author=$this->user->find($comment->commented_id);
            $comment->author = $author->individual->firstname . " " . $author->individual->surname;
            $comment->image = "http://umc.org.za/public/storage/individuals/" . $author->individual_id . "/" . $author->individual->image;
        }
        return $course;
    }
}
