<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\SermonsRepository;
use Bishopm\Connexion\Repositories\UsersRepository;
use Bishopm\Connexion\Models\Sermon;
use Bishopm\Connexion\Models\Individual;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateCommentRequest;
use Bishopm\Connexion\Http\Requests\CreateSermonRequest;
use Bishopm\Connexion\Http\Requests\UpdateSermonRequest;
use Bishopm\Connexion\Notifications\NewSermonComment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SermonsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	private $sermon,$user;

	public function __construct(SermonsRepository $sermon, UsersRepository $user)
    {
        $this->sermon = $sermon;
        $this->user = $user;
    }

	public function edit($series,Sermon $sermon)
    {
        $data['tags']=Sermon::allTags()->get();
        $data['btags']=array();
        foreach ($sermon->tags as $tag){
            $data['btags'][]=$tag->name;
        }
        $data['preachers'] = Individual::withTag('preacher')->get();
        $data['series'] = $series;
        $sermon->mp3=str_replace("http://","",$sermon->mp3);
        $sermon->mp3=str_replace("https://","",$sermon->mp3);
        $data['sermon'] = $sermon;
        return view('connexion::sermons.edit', $data);
    }

    public function create($series_id)
    {
        $data['tags']=Sermon::allTags()->get();
        $data['preachers']= Individual::withTag('preacher')->get();
        $data['series_id']=$series_id;
        return view('connexion::sermons.create',$data);
    }

	public function show(Sermon $sermon)
	{
        $data['sermon']=$sermon;
        return view('connexion::sermons.show',$data);
	}

    public function store(CreateSermonRequest $request)
    {
        $sermon=$this->sermon->create($request->except('tags'));
        $sermon->tag($request->tags);
        if ($sermon->mp3){
            $sermon->mp3 = "http://" . $sermon->mp3;
            $sermon->save();
        }
        return redirect()->route('admin.series.show',$request->series_id)
            ->withSuccess('New sermon added');
    }
	
    public function update($series, Sermon $sermon, UpdateSermonRequest $request)
    {
        $sermon=$this->sermon->update($sermon,$request->except('tags'));
        $sermon->tag($request->tags);
        if ($sermon->mp3){
            $sermon->mp3 = "http://" . $sermon->mp3;
            $sermon->save();
        }
        return redirect()->route('admin.series.show',$series)->withSuccess('Sermon has been updated');
    }

    public function addcomment($series, Sermon $sermon, CreateCommentRequest $request)
    {
        $user=$this->user->find($request->user);
        $user->comment($sermon, $request->newcomment);
        $preacher=$sermon->individual->user;
        $message=$user->individual->firstname . " " . $user->individual->surname . " has posted a comment on your sermon: '" . $sermon->title . "'";
        $preacher->notify(new NewSermonComment($message));
    }

    public function sermonapi($id){
        if ($id=="current"){
            $sermon=$this->sermon->mostRecent();
        } elseif ($id<>''){
            $sermon=$this->sermon->forApi($id);
        }
        foreach ($sermon->comments as $comment){
            $author=$this->user->find($comment->commented_id);
            $comment->author = $author->individual->firstname . " " . $author->individual->surname;
            $comment->image = "http://umc.org.za/public/storage/individuals/" . $author->individual_id . "/" . $author->individual->image;
            $comment->ago = Carbon::parse($comment->created_at)->diffForHumans();
        }
        return $sermon;
    }

    public function apiaddcomment($sermon, Request $request)
    {
        $sermon=$this->sermon->find($sermon);
        $user=$this->user->find($request->user_id);
        $user->comment($sermon, $request->comment);
    }    

    public function addtag($sermon, $tag)
    {
        $bb=Sermon::find($sermon);
        $bb->tag($tag);
    }

    public function removetag($sermon, $tag)
    {
        $bb=Sermon::find($sermon);
        $bb->untag($tag);
    }

}