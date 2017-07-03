<?php

Route::middleware(['handlecors'])->group(function () {
	Route::post('/api/login',['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\ApiAuthController@login','as'=>'api.login']);	
	Route::get('/api/blog/current', ['uses' => 'Bishopm\Connexion\Http\Controllers\BlogsController@apicurrentblog','as' => 'api.currentblog']);
	Route::get('/api/blog', ['uses' => 'Bishopm\Connexion\Http\Controllers\BlogsController@apiblog','as' => 'api.blog']);

	// Books
	Route::get('/api/books', ['uses' => 'Bishopm\Connexion\Http\Controllers\BooksController@apibooks','as' => 'api.books']);
	Route::get('/api/books/{book}', ['uses' => 'Bishopm\Connexion\Http\Controllers\BooksController@apibook','as' => 'api.books.show']);

	// Sermons
	Route::get('/api/sermons/{sermon?}', ['uses' => 'Bishopm\Connexion\Http\Controllers\SermonsController@sermonapi','as' => 'api.sermons']);
	Route::get('/api/series/{series?}', ['uses' => 'Bishopm\Connexion\Http\Controllers\SeriesController@seriesapi','as' => 'api.series']);

	Route::get('/api/readings', ['uses' => 'Bishopm\Connexion\Http\Controllers\WebController@lectionary','as' => 'api.lectionary']);
	Route::group(['middleware' => ['jwt.auth','handlecors']], function () {
		Route::get('/api/taskapi', ['uses' => 'Bishopm\Connexion\Http\Controllers\ActionsController@taskapi','as' => 'api.taskapi']);
		Route::get('/api/taskcompleted/{id}', ['uses' => 'Bishopm\Connexion\Http\Controllers\ActionsController@togglecompleted','as' => 'api.taskcompleted']);
		Route::get('/api/individual', ['uses' => 'Bishopm\Connexion\Http\Controllers\IndividualsController@api_individual','as' => 'api.individual']);	
	});
});