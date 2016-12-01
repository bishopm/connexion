<?php

namespace bishopm\base\Console;

use Illuminate\Console\Command;
use bishopm\base\Http\Controllers\Admin\Toodledo;
use bishopm\base\Repositories\UsersRepository;
use bishopm\base\Repositories\ActionsRepository;
use bishopm\base\Repositories\ProjectsRepository;
use bishopm\base\Repositories\FoldersRepository;
use bishopm\base\Entities\Folder;
use bishopm\base\Entities\Project;
use bishopm\base\Entities\Action;

class SyncToodledoCommand extends Command
{
    protected $signature = 'toodledo:sync {category}';
    protected $description = 'Sync Toodledo';
    private $users,$toodledo,$actions,$folders,$projects,$tags;

    public function __construct(Toodledo $toodledo, UsersRepository $users, ActionsRepository $actions, FoldersRepository $folders, ProjectsRepository $projects)
    {
        parent::__construct();
        $this->toodledo = new Toodledo;
        $this->projects = $projects;
        $this->folders = $folders;
        $this->actions = $actions;
        $this->users = $users->all();
    }

    public function handle()
    {
        // Category will be initial or hourly
        $category=$this->argument('category');
        //print  "Syncing with Toodledo: " . $category . "\n";
        if ($category == "hourly"){
            $ttt=3600;
        } else {
            $ttt=0;
        }
        $ts=time();
        //$tags=array();
        //foreach ($this->tags as $tag){
        //    $tags[]=$tag->name;
        //}
        $tco=array();
        foreach ($this->users as $user){

            $account=$this->toodledo->getData($user,'account');
            //Contexts
            $contexts=$this->toodledo->getData($user,'contexts');

            foreach ($contexts as $c){
                if (!in_array($c->name, $tags)){ // A new context has been added
                    //print  "Add context: " . $c->name;
                    $newc=new Tag();
                    $newc->name=$c->name;
                    $newc->slug=str_slug($c->name);
                    $newc->namespace='todo_action_context';
                    $newc->save();
                }
                $tco[$c->id]=$c->name;
            }

            //Tasks
            if (($ts - $account->lastedit_task < $ttt) or ($category=="initial")){
                $tasks=$this->toodledo->getData($user,'tasks',$category);
                //print  json_encode($tasks);
                $allt=array();
                foreach ($tasks as $t){
                    if (array_key_exists("id", $t)){
                        $thist=$this->actions->findbytid($t->id,$user->id);
                        if (!count($thist)){ // A new task has been added
                            $newt=array();
                            $newt['toodledo_id']=$t->id;
                            $newt['description']=$t->title;
                            $newt['user_id']=$user->id;
                            $newt['folder_id']=$t->status;
                            if ($t->tag<>""){
                                $newt['project_id']=$this->projects->getidbydescription($t->tag)['id'];
                            }
                            $newt['status_details']=$t->duedate;
                            $newt['completed']=$t->completed;
                            if ($t->context<>0){
                                $ccc=array();
                                $ccc[0]=str_slug($tco[$t->context]);
                                $newt['tags']=$ccc;
                            }
                            $this->actions->create($newt);
                            //print  "Added task: " . $t->title . "\n";
                        } else { // A task has been edited
                            if (($ts - $t->modified < $ttt) and ($category=="hourly")){
                                $thist->description=$t->title;
                                $thist->completed=$t->completed;
                                $thist->folder_id=$t->status;
                                if ($t->tag<>""){
                                    $thist->project_id=$this->projects->getidbydescription($t->tag)['id'];
                                } else {
                                    $thist->project_id=null;
                                }
                                $thist->status_details=$t->duedate;
                                $thist->user_id=$user->id;
                                if ($t->context<>0){
                                    $ccc=array();
                                    $ccc[0]=str_slug($tco[$t->context]);
                                    $thist->setTags($ccc);
                                }
                                $thist->save();
                                //print  "Updated task: " . $t->title . "\n";
                            }
                        }
                        $allt[]=$t->id;
                    }
                }
            }
            if (($ts - $account->lastdelete_task < $ttt) and ($category=="hourly")){
                // A task has been deleted
                foreach ($this->actions->findbyuid($user->id) as $ct){
                    if (!in_array($ct->toodledo_id,$allt)){
                        $ct->delete();
                    }
                }
            }
        }
    }
}
