<?php

Route::middleware(['handlecors'])->group(function () {
	Route::post('/api/login',['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\ApiAuthController@login','as'=>'api.login']);	
	Route::get('/api/blogs', ['uses' => 'Bishopm\Connexion\Http\Controllers\BlogsController@apiblogs','as' => 'api.blog']);
	Route::get('/api/blog/{blog}', ['uses' => 'Bishopm\Connexion\Http\Controllers\BlogsController@apiblog','as' => 'api.currentblog']);

	// Books
	Route::get('/api/books', ['uses' => 'Bishopm\Connexion\Http\Controllers\BooksController@apibooks','as' => 'api.books']);
	Route::get('/api/books/{book}', ['uses' => 'Bishopm\Connexion\Http\Controllers\BooksController@apibook','as' => 'api.books.show']);

	// Sermons
	Route::get('/api/sermons/{sermon?}', ['uses' => 'Bishopm\Connexion\Http\Controllers\SermonsController@sermonapi','as' => 'api.sermons']);
	Route::get('/api/series/{series?}', ['uses' => 'Bishopm\Connexion\Http\Controllers\SeriesController@seriesapi','as' => 'api.series']);

	Route::get('/api/readings', ['uses' => 'Bishopm\Connexion\Http\Controllers\WebController@lectionary','as' => 'api.lectionary']);
	Route::group(['middleware' => ['jwt.auth','handlecors']], function () {
		Route::post('/api/book/{book}/addcomment', ['uses' => 'Bishopm\Connexion\Http\Controllers\BooksController@apiaddcomment','as' => 'bookapi.add.comment']);
		Route::post('/api/blog/{blog}/addcomment', ['uses' => 'Bishopm\Connexion\Http\Controllers\BlogsController@apiaddcomment','as' => 'blogapi.add.comment']);
		Route::post('/api/course/{course}/addcomment', ['uses' => 'Bishopm\Connexion\Http\Controllers\CoursesController@apiaddcomment','as' => 'courseapi.add.comment']);
		Route::get('/api/groups', ['uses' => 'Bishopm\Connexion\Http\Controllers\GroupsController@api_groups','as' => 'api.groups']);	
		Route::get('/api/group/{group}', ['uses' => 'Bishopm\Connexion\Http\Controllers\GroupsController@api_group','as' => 'api.group']);			
		Route::post('/api/households', ['uses' => 'Bishopm\Connexion\Http\Controllers\HouseholdsController@api_households','as' => 'api.households']);
		Route::get('/api/household/{id}', ['uses' => 'Bishopm\Connexion\Http\Controllers\HouseholdsController@api_household','as' => 'api.household']);
		Route::post('/api/sermon/{sermon}/addcomment', ['uses' => 'Bishopm\Connexion\Http\Controllers\SermonsController@apiaddcomment','as' => 'sermonapi.add.comment']);
		Route::get('/api/taskapi', ['uses' => 'Bishopm\Connexion\Http\Controllers\ActionsController@taskapi','as' => 'api.taskapi']);
		Route::get('/api/taskcompleted/{id}', ['uses' => 'Bishopm\Connexion\Http\Controllers\ActionsController@togglecompleted','as' => 'api.taskcompleted']);
		Route::get('/api/individual', ['uses' => 'Bishopm\Connexion\Http\Controllers\IndividualsController@api_individual','as' => 'api.individual']);	
		Route::get('/api/messages/{user}/{receiver}', ['uses' => 'Bishopm\Connexion\Http\Controllers\MessagesController@api_messagethread','as' => 'api.messagethread']); 
		Route::get('/api/messages/{user}', ['uses' => 'Bishopm\Connexion\Http\Controllers\MessagesController@api_usermessages','as' => 'api.usermessages']); 
		Route::post('/api/sendmessage', ['uses' => 'Bishopm\Connexion\Http\Controllers\MessagesController@apisendmessage','as' => 'messageapi.send.comment']);
		Route::get('/api/subject/{tagname}', ['uses' => 'Bishopm\Connexion\Http\Controllers\WebController@apitag','as' => 'api.tag']); 
		Route::get('/api/users', ['uses' => 'Bishopm\Connexion\Http\Controllers\UsersController@api_users','as' => 'api.users']); 
		Route::get('/api/users/{id}', ['uses' => 'Bishopm\Connexion\Http\Controllers\UsersController@api_user','as' => 'api.user']); 
	});
});