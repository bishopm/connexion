<?php

namespace Bishopm\Connexion\Console;

use Illuminate\Console\Command;
use Bishopm\Connexion\Http\Controllers\Toodledo;
use Bishopm\Connexion\Repositories\UsersRepository;
use Bishopm\Connexion\Repositories\ActionsRepository;
use Bishopm\Connexion\Repositories\ProjectsRepository;
use Bishopm\Connexion\Repositories\FoldersRepository;
use Bishopm\Connexion\Models\Folder;
use Bishopm\Connexion\Models\Project;
use Bishopm\Connexion\Models\Action;

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
        print  "Syncing with Toodledo: " . $category . "\n";
        if ($category == "hourly"){
            $ttt=3600;
        } else {
            $ttt=0;
        }
        $ts=time();
        $tags=Action::allTags()->get();
        $tco=array();
        foreach ($this->users as $user){

            $account=$this->toodledo->getData($user,'account');
            //Contexts
            $contexts=$this->toodledo->getData($user,'contexts');
            foreach ($contexts as $c){
                $tco[$c->id]=$c->name;
            }

            //Tasks
            if (($ts - $account->lastedit_task < $ttt) or ($category=="initial")){

                $tasks=$this->toodledo->getData($user,'tasks',$category);
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
                            $newtask=$this->actions->create($newt);
                            if ($t->context<>0){
                                $newtask->tag($tco[$t->context]);
                            }
                            print  "Added task: " . $t->title . "\n";
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
                                $thist->save();                                
                                if ($t->context<>0){
                                    $thist->setTags($tco[$t->context]);
                                }
                                print  "Updated task: " . $t->title . "\n";
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
