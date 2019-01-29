<?php

Route::middleware(['handlecors'])->group(function () {
    
    // Authentication
    Route::post('/api/login', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\ApiAuthController@login','as'=>'api.login']);
    Route::post('/api/worshiplogin', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\ApiAuthController@worshiplogin','as'=>'api.worshiplogin']);
    Route::post('/api/password/email', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\ApiAuthController@sendResetLinkEmail','as'=>'api.sendResetLinkEmail']);
    Route::get('/api/newuser/checkname/{username}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@checkname','as'=>'api.checkname']);
    Route::get('/api/getusername/{email}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@getusername','as'=>'api.getusername']);
    Route::post('/api/checkmail', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@checkEmail','as'=>'api.checkmail']);
    Route::post('/api/register', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\RegisterController@register','as'=>'api.register']);

    // Blogs
    Route::get('/api/blogs', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\BlogsController@apiblogs','as' => 'api.blog']);
    Route::get('/api/blog/{blog}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\BlogsController@apiblog','as' => 'api.currentblog']);

    // Books
    Route::get('/api/books', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\BooksController@apibooks','as' => 'api.books']);
    Route::get('/api/books/{book}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\BooksController@apibook','as' => 'api.books.show']);

    // Courses
    Route::get('/api/courses', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\CoursesController@api_courses','as' => 'api.courses']);
    Route::get('/api/courses/{course}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\CoursesController@api_course','as' => 'api.course']);

    // Groups
    Route::get('/api/groups', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\GroupsController@api_groups','as' => 'api.groups']);
    Route::get('/api/group/{group}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\GroupsController@api_group','as' => 'api.group']);

    // Sermons
    Route::get('/api/sermons/{sermon?}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\SermonsController@sermonapi','as' => 'api.sermons']);
    Route::get('/api/series/{series?}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\SeriesController@seriesapi','as' => 'api.series']);

    Route::get('/api/readings', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@lectionary','as' => 'api.lectionary']);
    Route::group(['middleware' => ['jwt.auth','handlecors']], function () {
        Route::post('/api/book/{book}/addcomment', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\BooksController@apiaddcomment','as' => 'bookapi.add.comment']);
        Route::post('/api/blog/{blog}/addcomment', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\BlogsController@apiaddcomment','as' => 'blogapi.add.comment']);
        Route::get('/api/comments', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@api_comments','as' => 'api.comments']);
        Route::post('/api/course/{course}/addcomment', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\CoursesController@apiaddcomment','as' => 'courseapi.add.comment']);
        Route::get('/api/folders', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\FoldersController@api_folders','as' => 'api.folders']);
        Route::post('/api/households', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\HouseholdsController@api_households','as' => 'api.households']);
        Route::get('/api/household/{id}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\HouseholdsController@api_household','as' => 'api.household']);
        Route::post('/api/sermon/{sermon}/addcomment', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\SermonsController@apiaddcomment','as' => 'sermonapi.add.comment']);
        Route::get('/api/taskapi', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\ActionsController@taskapi','as' => 'api.taskapi']);
        Route::get('/api/taskcompleted/{id}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\ActionsController@togglecompleted','as' => 'api.taskcompleted']);
        Route::post('/api/newtask', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\ActionsController@api_newtask','as' => 'api.task.create']);
        Route::get('/api/individual', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@api_individual','as' => 'api.individual']);
        Route::get('/api/messages/{user}/{receiver}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\MessagesController@api_messagethread','as' => 'api.messagethread']);
        Route::get('/api/messages/{user}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\MessagesController@api_usermessages','as' => 'api.usermessages']);
        Route::get('/api/project/{project}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\ProjectsController@api_project','as' => 'api.project']);
        Route::get('/api/projects/{indiv?}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\ProjectsController@api_projects','as' => 'api.projects']);
        Route::get('/api/projectindivs', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\ActionsController@api_projectindivs','as' => 'api.projectindivs']);
        Route::post('/api/sendmessage', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\MessagesController@apisendmessage','as' => 'messageapi.send.comment']);
        Route::get('/api/subject/{tagname}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@apitag','as' => 'api.tag']);
        Route::get('/api/users', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\UsersController@api_users','as' => 'api.users']);
        Route::get('/api/users/{id}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\UsersController@api_user','as' => 'api.user']);
    });
});
