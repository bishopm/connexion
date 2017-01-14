<?php

Route::group(['middleware' => ['web','role:open']], function () {
	Route::get('/', ['uses' => 'bishopm\base\Http\Controllers\WebController@home','as' => 'homepage']);
	Route::get('login',['uses'=>'bishopm\base\Http\Controllers\Auth\LoginController@showLoginForm','as'=>'showlogin']);
	Route::post('login',['uses'=>'bishopm\base\Http\Controllers\Auth\LoginController@login','as'=>'login']);
	Route::get('/blog/{slug}', ['uses' => 'bishopm\base\Http\Controllers\WebController@webblog','as' => 'webblog']);
	Route::get('/people/{slug}', ['uses' => 'bishopm\base\Http\Controllers\WebController@webperson','as' => 'webperson']);
	Route::get('/subject/{tag}', ['uses' => 'bishopm\base\Http\Controllers\WebController@websubject','as' => 'websubject']);
});

Route::group(['middleware' => ['web','role:admin#editor#backend']], function () {

	// Dashboard
	Route::get('admin',['uses'=>'bishopm\base\Http\Controllers\WebController@dashboard','as'=>'dashboard']);

	// Logout
	Route::post('logout',['uses'=>'bishopm\base\Http\Controllers\Auth\LoginController@logout','as'=>'logout']);

	// Actions
	Route::get('admin/actions',['uses'=>'bishopm\base\Http\Controllers\ActionsController@index','as'=>'admin.actions.index']);
	Route::get('admin/actions/create',['uses'=>'bishopm\base\Http\Controllers\ActionsController@create','as'=>'admin.actions.create']);
	Route::get('admin/actions/{action}',['uses'=>'bishopm\base\Http\Controllers\ActionsController@show','as'=>'admin.actions.show']);
	Route::get('admin/actions/{action}/edit',['uses'=>'bishopm\base\Http\Controllers\ActionsController@edit','as'=>'admin.actions.edit']);
	Route::put('admin/actions/{action}',['uses'=>'bishopm\base\Http\Controllers\ActionsController@update','as'=>'admin.actions.update']);
	Route::post('admin/actions',['uses'=>'bishopm\base\Http\Controllers\ActionsController@store','as'=>'admin.actions.store']);
    Route::delete('admin/actions/{action}',['uses'=>'bishopm\base\Http\Controllers\ActionsController@destroy','as'=>'admin.actions.destroy']);
	Route::get('admin/actions/addtag/{action}/{tag}', ['uses' => 'bishopm\base\Http\Controllers\ActionsController@addtag','as' => 'admin.actions.addtag']);
    Route::get('admin/actions/removetag/{action}/{tag}', ['uses' => 'bishopm\base\Http\Controllers\ActionsController@removetag','as' => 'admin.actions.removetag']);
    Route::get('admin/actions/togglecompleted/{action}', ['uses' => 'bishopm\base\Http\Controllers\ActionsController@togglecompleted','as' => 'admin.actions.togglecompleted']);
   

	// Blogs
	Route::get('admin/blogs',['uses'=>'bishopm\base\Http\Controllers\BlogsController@index','as'=>'admin.blogs.index']);
	Route::get('admin/blogs/create',['uses'=>'bishopm\base\Http\Controllers\BlogsController@create','as'=>'admin.blogs.create']);
	Route::get('admin/blogs/{blog}',['uses'=>'bishopm\base\Http\Controllers\BlogsController@show','as'=>'admin.blogs.show']);
	Route::get('admin/blogs/{blog}/edit',['uses'=>'bishopm\base\Http\Controllers\BlogsController@edit','as'=>'admin.blogs.edit']);
	Route::put('admin/blogs/{blog}',['uses'=>'bishopm\base\Http\Controllers\BlogsController@update','as'=>'admin.blogs.update']);
	Route::post('admin/blogs',['uses'=>'bishopm\base\Http\Controllers\BlogsController@store','as'=>'admin.blogs.store']);
    Route::delete('admin/blogs/{blog}',['uses'=>'bishopm\base\Http\Controllers\BlogsController@destroy','as'=>'admin.blogs.destroy']);
	Route::get('admin/blogs/addtag/{blog}/{tag}', ['uses' => 'bishopm\base\Http\Controllers\BlogsController@addtag','as' => 'admin.blogs.addtag']);
    Route::get('admin/blogs/removetag/{blog}/{tag}', ['uses' => 'bishopm\base\Http\Controllers\BlogsController@removetag','as' => 'admin.blogs.removetag']);    

	// Chords
    Route::get('admin/worship/chords',['uses'=>'bishopm\base\Http\Controllers\GchordsController@index','as'=>'admin.chords.index']);
    Route::get('admin/worship/chords/create/{name?}',['uses'=>'bishopm\base\Http\Controllers\GchordsController@create','as'=>'admin.chords.create']);
    Route::post('admin/worship/chords',['uses'=>'bishopm\base\Http\Controllers\GchordsController@store','as'=>'admin.chords.store']);
    Route::get('admin/worship/chords/{chord}/edit',['uses'=>'bishopm\base\Http\Controllers\GchordsController@edit','as'=>'admin.chords.edit']);
    Route::get('admin/worship/chords/{chord}',['uses'=>'bishopm\base\Http\Controllers\GchordsController@show','as'=>'admin.chords.show']);
    Route::put('admin/worship/chords/{chord}',['uses'=>'bishopm\base\Http\Controllers\GchordsController@update','as'=>'admin.chords.update']);
    Route::delete('admin/worship/chords/{chord}',['uses'=>'bishopm\base\Http\Controllers\GchordsController@destroy','as'=>'admin.chords.destroy']);

	// Folders
	Route::get('admin/folders',['uses'=>'bishopm\base\Http\Controllers\FoldersController@index','as'=>'admin.folders.index']);
	Route::get('admin/folders/create',['uses'=>'bishopm\base\Http\Controllers\FoldersController@create','as'=>'admin.folders.create']);
	Route::get('admin/folders/{folder}',['uses'=>'bishopm\base\Http\Controllers\FoldersController@show','as'=>'admin.folders.show']);
	Route::get('admin/folders/{folder}/edit',['uses'=>'bishopm\base\Http\Controllers\FoldersController@edit','as'=>'admin.folders.edit']);
	Route::put('admin/folders/{folder}',['uses'=>'bishopm\base\Http\Controllers\FoldersController@update','as'=>'admin.folders.update']);
	Route::post('admin/folders',['uses'=>'bishopm\base\Http\Controllers\FoldersController@store','as'=>'admin.folders.store']);
    Route::delete('admin/folders/{folder}',['uses'=>'bishopm\base\Http\Controllers\FoldersController@destroy','as'=>'admin.folders.destroy']);

	// Groups
	Route::get('admin/groups',['uses'=>'bishopm\base\Http\Controllers\GroupsController@index','as'=>'admin.groups.index']);
	Route::get('admin/groups/create',['uses'=>'bishopm\base\Http\Controllers\GroupsController@create','as'=>'admin.groups.create']);
	Route::get('admin/groups/{group}',['uses'=>'bishopm\base\Http\Controllers\GroupsController@show','as'=>'admin.groups.show']);
	Route::get('admin/groups/{group}/edit',['uses'=>'bishopm\base\Http\Controllers\GroupsController@edit','as'=>'admin.groups.edit']);
	Route::put('admin/groups/{group}',['uses'=>'bishopm\base\Http\Controllers\GroupsController@update','as'=>'admin.groups.update']);
	Route::post('admin/groups',['uses'=>'bishopm\base\Http\Controllers\GroupsController@store','as'=>'admin.groups.store']);
    Route::delete('admin/groups/{group}',['uses'=>'bishopm\base\Http\Controllers\GroupsController@destroy','as'=>'admin.groups.destroy']);
    Route::get('admin/groups/{group}/addmember/{member}', ['uses' => 'bishopm\base\Http\Controllers\GroupsController@addmember','as' => 'admin.groups.addmember']);
    Route::get('admin/groups/{group}/removemember/{member}', ['uses' => 'bishopm\base\Http\Controllers\GroupsController@removemember','as' => 'admin.groups.removemember']);

	// Households
	Route::get('admin/households',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@index','as'=>'admin.households.index']);
	Route::get('admin/households/create',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@create','as'=>'admin.households.create']);
	Route::get('admin/households/{household}',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@show','as'=>'admin.households.show']);
	Route::get('admin/households/{household}/edit',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@edit','as'=>'admin.households.edit']);
	Route::put('admin/households/{household}',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@update','as'=>'admin.households.update']);
	Route::post('admin/households',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@store','as'=>'admin.households.store']);
    Route::delete('admin/households/{household}',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@destroy','as'=>'admin.households.destroy']);

	// Individuals
	Route::get('admin/households/{household}/individuals/create',['uses'=>'bishopm\base\Http\Controllers\IndividualsController@create','as'=>'admin.individuals.create']);
	Route::get('admin/households/{household}/individuals/{individual}',['uses'=>'bishopm\base\Http\Controllers\IndividualsController@show','as'=>'admin.individuals.show']);
	Route::get('admin/households/{household}/individuals/{individual}/edit',['uses'=>'bishopm\base\Http\Controllers\IndividualsController@edit','as'=>'admin.individuals.edit']);
	Route::put('admin/households/{household}/individuals/{individual}',['uses'=>'bishopm\base\Http\Controllers\IndividualsController@update','as'=>'admin.individuals.update']);
	Route::post('admin/households/{household}/individuals',['uses'=>'bishopm\base\Http\Controllers\IndividualsController@store','as'=>'admin.individuals.store']);
    Route::delete('admin/households/{household}/individuals/{individual}',['uses'=>'bishopm\base\Http\Controllers\IndividualsController@destroy','as'=>'admin.individuals.destroy']);
    Route::get('admin/individuals/addgroup/{member}/{group}', ['uses' => 'bishopm\base\Http\Controllers\IndividualsController@addgroup','as' => 'admin.individuals.addgroup']);
    Route::get('admin/individuals/removegroup/{member}/{group}', ['uses' => 'bishopm\base\Http\Controllers\IndividualsController@removegroup','as' => 'admin.individuals.removegroup']);
    Route::get('admin/individuals/addtag/{member}/{tag}', ['uses' => 'bishopm\base\Http\Controllers\IndividualsController@addtag','as' => 'admin.individuals.addtag']);
    Route::get('admin/individuals/removetag/{member}/{tag}', ['uses' => 'bishopm\base\Http\Controllers\IndividualsController@removetag','as' => 'admin.individuals.removetag']);
	Route::get('admin/individuals/{individual}/removemedia',['uses'=>'bishopm\base\Http\Controllers\IndividualsController@removemedia','as'=>'admin.individuals.removemedia']);

	// Menus
	Route::get('admin/menus',['uses'=>'bishopm\base\Http\Controllers\MenusController@index','as'=>'admin.menus.index']);
	Route::get('admin/menus/create',['uses'=>'bishopm\base\Http\Controllers\MenusController@create','as'=>'admin.menus.create']);
	Route::get('admin/menus/{menu}',['uses'=>'bishopm\base\Http\Controllers\MenusController@show','as'=>'admin.menus.show']);
	Route::get('admin/menus/{menu}/edit',['uses'=>'bishopm\base\Http\Controllers\MenusController@edit','as'=>'admin.menus.edit']);
	Route::put('admin/menus/{menu}',['uses'=>'bishopm\base\Http\Controllers\MenusController@update','as'=>'admin.menus.update']);
	Route::post('admin/menus',['uses'=>'bishopm\base\Http\Controllers\MenusController@store','as'=>'admin.menus.store']);
    Route::delete('admin/menus/{menu}',['uses'=>'bishopm\base\Http\Controllers\MenusController@destroy','as'=>'admin.menus.destroy']);

	// Menuitems
	Route::get('admin/menus/{menu}/menuitems',['uses'=>'bishopm\base\Http\Controllers\MenuitemsController@index','as'=>'admin.menuitems.index']);
	Route::get('admin/menus/{menu}/menuitems/create',['uses'=>'bishopm\base\Http\Controllers\MenuitemsController@create','as'=>'admin.menuitems.create']);
	Route::get('admin/menus/{menu}/menuitems/{menuitem}',['uses'=>'bishopm\base\Http\Controllers\MenuitemsController@show','as'=>'admin.menuitems.show']);
	Route::get('admin/menus/{menu}/menuitems/{menuitem}/edit',['uses'=>'bishopm\base\Http\Controllers\MenuitemsController@edit','as'=>'admin.menuitems.edit']);
	Route::put('admin/menus/{menu}/menuitems/{menuitem}',['uses'=>'bishopm\base\Http\Controllers\MenuitemsController@update','as'=>'admin.menuitems.update']);
	Route::post('admin/menus/{menu}/menuitems',['uses'=>'bishopm\base\Http\Controllers\MenuitemsController@store','as'=>'admin.menuitems.store']);
	Route::post('admin/menus/{menu}/menuitems/update',['uses'=>'bishopm\base\Http\Controllers\MenuitemsController@reorder','as'=>'admin.menuitems.reorder']);
    Route::delete('admin/menus/{menu}/menuitems/{menuitem}',['uses'=>'bishopm\base\Http\Controllers\MenuitemsController@destroy','as'=>'admin.menuitems.destroy']);    

	// Pages
	Route::get('admin/pages',['uses'=>'bishopm\base\Http\Controllers\PagesController@index','as'=>'admin.pages.index']);
	Route::get('admin/pages/create',['uses'=>'bishopm\base\Http\Controllers\PagesController@create','as'=>'admin.pages.create']);
	Route::get('admin/pages/{page}',['uses'=>'bishopm\base\Http\Controllers\PagesController@show','as'=>'admin.pages.show']);
	Route::get('admin/pages/{page}/edit',['uses'=>'bishopm\base\Http\Controllers\PagesController@edit','as'=>'admin.pages.edit']);
	Route::put('admin/pages/{page}',['uses'=>'bishopm\base\Http\Controllers\PagesController@update','as'=>'admin.pages.update']);
	Route::post('admin/pages',['uses'=>'bishopm\base\Http\Controllers\PagesController@store','as'=>'admin.pages.store']);
    Route::delete('admin/pages/{page}',['uses'=>'bishopm\base\Http\Controllers\PagesController@destroy','as'=>'admin.pages.destroy']);

	// Pastorals
    Route::get('admin/households/{household}/pastorals', ['uses' => 'bishopm\base\Http\Controllers\PastoralsController@index','as' => 'admin.pastorals.index']);
    Route::post('admin/households/{household}/pastorals', ['uses' => 'bishopm\base\Http\Controllers\PastoralsController@store','as' => 'admin.pastorals.store']);
    Route::put('admin/households/{household}/pastorals', ['uses' => 'bishopm\base\Http\Controllers\PastoralsController@update','as' => 'admin.pastorals.update']);
    Route::delete('admin/households/{household}/pastorals/{pastoral}', ['uses' => 'bishopm\base\Http\Controllers\PastoralsController@destroy','as' => 'admin.pastorals.destroy']);

	// Preachers
	Route::get('admin/preachers',['uses'=>'bishopm\base\Http\Controllers\PreachersController@index','as'=>'admin.preachers.index']);
	Route::get('admin/preachers/create',['uses'=>'bishopm\base\Http\Controllers\PreachersController@create','as'=>'admin.preachers.create']);
	Route::get('admin/preachers/{preacher}',['uses'=>'bishopm\base\Http\Controllers\PreachersController@show','as'=>'admin.preachers.show']);
	Route::get('admin/preachers/{preacher}/edit',['uses'=>'bishopm\base\Http\Controllers\PreachersController@edit','as'=>'admin.preachers.edit']);
	Route::put('admin/preachers/{preacher}',['uses'=>'bishopm\base\Http\Controllers\PreachersController@update','as'=>'admin.preachers.update']);
	Route::post('admin/preachers',['uses'=>'bishopm\base\Http\Controllers\PreachersController@store','as'=>'admin.preachers.store']);
    Route::delete('admin/preachers/{preacher}',['uses'=>'bishopm\base\Http\Controllers\PreachersController@destroy','as'=>'admin.preachers.destroy']);

	// Projects
	Route::get('admin/projects',['uses'=>'bishopm\base\Http\Controllers\ProjectsController@index','as'=>'admin.projects.index']);
	Route::get('admin/projects/create',['uses'=>'bishopm\base\Http\Controllers\ProjectsController@create','as'=>'admin.projects.create']);
	Route::get('admin/projects/{project}',['uses'=>'bishopm\base\Http\Controllers\ProjectsController@show','as'=>'admin.projects.show']);
	Route::get('admin/projects/{project}/edit',['uses'=>'bishopm\base\Http\Controllers\ProjectsController@edit','as'=>'admin.projects.edit']);
	Route::put('admin/projects/{project}',['uses'=>'bishopm\base\Http\Controllers\ProjectsController@update','as'=>'admin.projects.update']);
	Route::post('admin/projects',['uses'=>'bishopm\base\Http\Controllers\ProjectsController@store','as'=>'admin.projects.store']);
    Route::delete('admin/projects/{project}',['uses'=>'bishopm\base\Http\Controllers\ProjectsController@destroy','as'=>'admin.projects.destroy']);

	// Ratings
	Route::get('admin/resources/{resource}/ratings',['uses'=>'bishopm\base\Http\Controllers\RatingsController@index','as'=>'admin.ratings.index']);
	Route::get('admin/resources/{resource}/ratings/create',['uses'=>'bishopm\base\Http\Controllers\RatingsController@create','as'=>'admin.ratings.create']);
	Route::get('admin/resources/{resource}/ratings/{rating}',['uses'=>'bishopm\base\Http\Controllers\RatingsController@show','as'=>'admin.ratings.show']);
	Route::get('admin/resources/{resource}/ratings/{rating}/edit',['uses'=>'bishopm\base\Http\Controllers\RatingsController@edit','as'=>'admin.ratings.edit']);
	Route::put('admin/resources/{resource}/ratings/{rating}',['uses'=>'bishopm\base\Http\Controllers\RatingsController@update','as'=>'admin.ratings.update']);
	Route::post('admin/resources/{resource}/ratings',['uses'=>'bishopm\base\Http\Controllers\RatingsController@store','as'=>'admin.ratings.store']);
    Route::delete('admin/resources/{resource}/ratings/{rating}',['uses'=>'bishopm\base\Http\Controllers\RatingsController@destroy','as'=>'admin.ratings.destroy']);

	// Resources
	Route::get('admin/resources',['uses'=>'bishopm\base\Http\Controllers\ResourcesController@index','as'=>'admin.resources.index']);
	Route::get('admin/resources/create',['uses'=>'bishopm\base\Http\Controllers\ResourcesController@create','as'=>'admin.resources.create']);
	Route::get('admin/resources/{resource}',['uses'=>'bishopm\base\Http\Controllers\ResourcesController@show','as'=>'admin.resources.show']);
	Route::get('admin/resources/{resource}/edit',['uses'=>'bishopm\base\Http\Controllers\ResourcesController@edit','as'=>'admin.resources.edit']);
	Route::put('admin/resources/{resource}',['uses'=>'bishopm\base\Http\Controllers\ResourcesController@update','as'=>'admin.resources.update']);
	Route::post('admin/resources',['uses'=>'bishopm\base\Http\Controllers\ResourcesController@store','as'=>'admin.resources.store']);
    Route::delete('admin/resources/{resource}',['uses'=>'bishopm\base\Http\Controllers\ResourcesController@destroy','as'=>'admin.resources.destroy']);
	Route::get('admin/resources/{resource}/removemedia',['uses'=>'bishopm\base\Http\Controllers\ResourcesController@removemedia','as'=>'admin.resources.removemedia']);    

	// Series
	Route::get('admin/series',['uses'=>'bishopm\base\Http\Controllers\SeriesController@index','as'=>'admin.series.index']);
	Route::get('admin/series/create',['uses'=>'bishopm\base\Http\Controllers\SeriesController@create','as'=>'admin.series.create']);
	Route::get('admin/series/{series}',['uses'=>'bishopm\base\Http\Controllers\SeriesController@show','as'=>'admin.series.show']);
	Route::get('admin/series/{series}/edit',['uses'=>'bishopm\base\Http\Controllers\SeriesController@edit','as'=>'admin.series.edit']);
	Route::put('admin/series/{series}',['uses'=>'bishopm\base\Http\Controllers\SeriesController@update','as'=>'admin.series.update']);
	Route::post('admin/series',['uses'=>'bishopm\base\Http\Controllers\SeriesController@store','as'=>'admin.series.store']);
    Route::delete('admin/series/{series}',['uses'=>'bishopm\base\Http\Controllers\SeriesController@destroy','as'=>'admin.series.destroy']);
	Route::get('admin/series/{series}/removemedia',['uses'=>'bishopm\base\Http\Controllers\SeriesController@removemedia','as'=>'admin.series.removemedia']);    

	// Sermons
	Route::get('admin/series/{series}/sermons',['uses'=>'bishopm\base\Http\Controllers\SermonsController@index','as'=>'admin.sermons.index']);
	Route::get('admin/series/{series}/sermons/create',['uses'=>'bishopm\base\Http\Controllers\SermonsController@create','as'=>'admin.sermons.create']);
	Route::get('admin/series/{series}/sermons/{sermon}',['uses'=>'bishopm\base\Http\Controllers\SermonsController@show','as'=>'admin.sermons.show']);
	Route::get('admin/series/{series}/sermons/{sermon}/edit',['uses'=>'bishopm\base\Http\Controllers\SermonsController@edit','as'=>'admin.sermons.edit']);
	Route::put('admin/series/{series}/sermons/{sermon}',['uses'=>'bishopm\base\Http\Controllers\SermonsController@update','as'=>'admin.sermons.update']);
	Route::post('admin/series/{series}/sermons',['uses'=>'bishopm\base\Http\Controllers\SermonsController@store','as'=>'admin.sermons.store']);
    Route::delete('admin/series/{series}/sermons/{sermon}',['uses'=>'bishopm\base\Http\Controllers\SermonsController@destroy','as'=>'admin.sermons.destroy']);

	// Services
	Route::get('admin/societies/{society}/services',['uses'=>'bishopm\base\Http\Controllers\ServicesController@index','as'=>'admin.services.index']);
	Route::get('admin/societies/{society}/services/create',['uses'=>'bishopm\base\Http\Controllers\ServicesController@create','as'=>'admin.services.create']);
	Route::get('admin/societies/{society}/services/{service}',['uses'=>'bishopm\base\Http\Controllers\ServicesController@show','as'=>'admin.services.show']);
	Route::get('admin/societies/{society}/services/{service}/edit',['uses'=>'bishopm\base\Http\Controllers\ServicesController@edit','as'=>'admin.services.edit']);
	Route::put('admin/societies/{society}/services/{service}',['uses'=>'bishopm\base\Http\Controllers\ServicesController@update','as'=>'admin.services.update']);
	Route::post('admin/societies/{society}/services',['uses'=>'bishopm\base\Http\Controllers\ServicesController@store','as'=>'admin.services.store']);
    Route::delete('admin/societies/{society}/services/{service}',['uses'=>'bishopm\base\Http\Controllers\ServicesController@destroy','as'=>'admin.services.destroy']);

	// Setitems
    Route::post('admin/worship/setitems','bishopm\base\Http\Controllers\SetitemsController@store');
    Route::delete('admin/worship/setitems/{setitem}','bishopm\base\Http\Controllers\SetitemsController@destroy');

    // Sets
    Route::get('admin/worship/sets',['uses'=>'bishopm\base\Http\Controllers\SetsController@index','as'=>'admin.sets.index']);
    Route::get('admin/worship/sets/create',['uses'=>'bishopm\base\Http\Controllers\SetsController@create','as'=>'admin.sets.create']);
    Route::post('admin/worship/sets',['uses'=>'bishopm\base\Http\Controllers\SetsController@store','as'=>'admin.sets.store']);
    Route::get('admin/worship/sets/{set}/edit',['uses'=>'bishopm\base\Http\Controllers\SetsController@edit','as'=>'admin.sets.edit']);
    Route::get('admin/worship/sets/{set}/{mode?}',['uses'=>'bishopm\base\Http\Controllers\SetsController@show','as'=>'admin.sets.show']);
    Route::get('admin/worship/setsapi/{set}','bishopm\base\Http\Controllers\SetsController@showapi');
    Route::put('admin/worship/sets/{set}',['uses'=>'bishopm\base\Http\Controllers\SetsController@update','as'=>'admin.sets.update']);
    Route::put('admin/worship/setsapi/{set}','bishopm\base\Http\Controllers\SetsController@updateapi');
    Route::delete('admin/worship/sets/{set}',['uses'=>'bishopm\base\Http\Controllers\SetsController@destroy','as'=>'admin.sets.destroy']);
    Route::post('admin/worship/sets/sendemail','bishopm\base\Http\Controllers\SetsController@sendEmail');

	// Slides
	Route::get('admin/slides',['uses'=>'bishopm\base\Http\Controllers\SlidesController@index','as'=>'admin.slides.index']);
	Route::get('admin/slides/create',['uses'=>'bishopm\base\Http\Controllers\SlidesController@create','as'=>'admin.slides.create']);
	Route::get('admin/slides/{slide}',['uses'=>'bishopm\base\Http\Controllers\SlidesController@show','as'=>'admin.slides.show']);
	Route::get('admin/slides/{slide}/edit',['uses'=>'bishopm\base\Http\Controllers\SlidesController@edit','as'=>'admin.slides.edit']);
	Route::put('admin/slides/{slide}',['uses'=>'bishopm\base\Http\Controllers\SlidesController@update','as'=>'admin.slides.update']);
	Route::post('admin/slides',['uses'=>'bishopm\base\Http\Controllers\SlidesController@store','as'=>'admin.slides.store']);
    Route::delete('admin/slides/{slide}',['uses'=>'bishopm\base\Http\Controllers\SlidesController@destroy','as'=>'admin.slides.destroy']);
	Route::get('admin/slides/{slide}/removemedia',['uses'=>'bishopm\base\Http\Controllers\SlidesController@removemedia','as'=>'admin.slides.removemedia']);    

	// Societies
	Route::get('admin/societies',['uses'=>'bishopm\base\Http\Controllers\SocietiesController@index','as'=>'admin.societies.index']);
	Route::get('admin/societies/create',['uses'=>'bishopm\base\Http\Controllers\SocietiesController@create','as'=>'admin.societies.create']);
	Route::get('admin/societies/{society}',['uses'=>'bishopm\base\Http\Controllers\SocietiesController@show','as'=>'admin.societies.show']);
	Route::get('admin/societies/{society}/edit',['uses'=>'bishopm\base\Http\Controllers\SocietiesController@edit','as'=>'admin.societies.edit']);
	Route::put('admin/societies/{society}',['uses'=>'bishopm\base\Http\Controllers\SocietiesController@update','as'=>'admin.societies.update']);
	Route::post('admin/societies',['uses'=>'bishopm\base\Http\Controllers\SocietiesController@store','as'=>'admin.societies.store']);
    Route::delete('admin/societies/{society}',['uses'=>'bishopm\base\Http\Controllers\SocietiesController@destroy','as'=>'admin.societies.destroy']);

    // Songs
    Route::get('admin/worship/songs',['uses'=>'bishopm\base\Http\Controllers\SongsController@index','as'=>'admin.songs.index']);
    Route::get('admin/worship/songs/create',['uses'=>'bishopm\base\Http\Controllers\SongsController@create','as'=>'admin.songs.create']);
    Route::post('admin/worship/songs',['uses'=>'bishopm\base\Http\Controllers\SongsController@store','as'=>'admin.songs.store']);
    Route::get('admin/worship/songs/{song}/edit',['uses'=>'bishopm\base\Http\Controllers\SongsController@edit','as'=>'admin.songs.edit']);
    Route::get('admin/worship/songs/{song}/{mode?}',['uses'=>'bishopm\base\Http\Controllers\SongsController@show','as'=>'admin.songs.show']);
    Route::get('admin/worship/songapi/{song}','bishopm\base\Http\Controllers\SongsController@showapi');
    Route::put('admin/worship/songs/{song}',['uses'=>'bishopm\base\Http\Controllers\SongsController@update','as'=>'admin.songs.update']);
    Route::delete('admin/worship/songs/{song}',['uses'=>'bishopm\base\Http\Controllers\SongsController@destroy','as'=>'admin.songs.destroy']);

    Route::post('admin/worship/convert', 'bishopm\base\Http\Controllers\SongsController@convert');
    Route::get('admin/worship', 'bishopm\base\Http\Controllers\SongsController@index');

	// Specialdays
    Route::get('admin/households/{household}/specialdays', ['uses' => 'bishopm\base\Http\Controllers\SpecialdaysController@index','as' => 'admin.specialdays.index']);
    Route::post('admin/households/{household}/specialdays', ['uses' => 'bishopm\base\Http\Controllers\SpecialdaysController@store','as' => 'admin.specialdays.store']);
    Route::put('admin/households/{household}/specialdays', ['uses' => 'bishopm\base\Http\Controllers\SpecialdaysController@update','as' => 'admin.specialdays.update']);
    Route::delete('admin/households/{household}/specialdays/{specialday}', ['uses' => 'bishopm\base\Http\Controllers\SpecialdaysController@destroy','as' => 'admin.specialdays.destroy']);

    Route::group(['middleware' => ['web','role:admin']], function () {

		// Permissions
		Route::get('admin/permissions',['uses'=>'bishopm\base\Http\Controllers\PermissionsController@index','as'=>'admin.permissions.index']);
		Route::get('admin/permissions/create',['uses'=>'bishopm\base\Http\Controllers\PermissionsController@create','as'=>'admin.permissions.create']);
		Route::get('admin/permissions/{permission}',['uses'=>'bishopm\base\Http\Controllers\PermissionsController@show','as'=>'admin.permissions.show']);
		Route::get('admin/permissions/{permission}/edit',['uses'=>'bishopm\base\Http\Controllers\PermissionsController@edit','as'=>'admin.permissions.edit']);
		Route::put('admin/permissions/{permission}',['uses'=>'bishopm\base\Http\Controllers\PermissionsController@update','as'=>'admin.permissions.update']);
		Route::post('admin/permissions',['uses'=>'bishopm\base\Http\Controllers\PermissionsController@store','as'=>'admin.permissions.store']);
	    Route::delete('admin/permissions/{permission}',['uses'=>'bishopm\base\Http\Controllers\PermissionsController@destroy','as'=>'admin.permissions.destroy']);

		// Roles
		Route::get('admin/roles',['uses'=>'bishopm\base\Http\Controllers\RolesController@index','as'=>'admin.roles.index']);
		Route::get('admin/roles/create',['uses'=>'bishopm\base\Http\Controllers\RolesController@create','as'=>'admin.roles.create']);
		Route::get('admin/roles/{role}',['uses'=>'bishopm\base\Http\Controllers\RolesController@show','as'=>'admin.roles.show']);
		Route::get('admin/roles/{role}/edit',['uses'=>'bishopm\base\Http\Controllers\RolesController@edit','as'=>'admin.roles.edit']);
		Route::put('admin/roles/{role}',['uses'=>'bishopm\base\Http\Controllers\RolesController@update','as'=>'admin.roles.update']);
		Route::post('admin/roles',['uses'=>'bishopm\base\Http\Controllers\RolesController@store','as'=>'admin.roles.store']);
	    Route::delete('admin/roles/{role}',['uses'=>'bishopm\base\Http\Controllers\RolesController@destroy','as'=>'admin.roles.destroy']);
	    Route::get('admin/roles/{role}/addpermission/{permission}', ['uses' => 'bishopm\base\Http\Controllers\RolesController@addpermission','as' => 'admin.roles.addpermission']);
	    Route::get('admin/roles/{role}/removepermission/{permission}', ['uses' => 'bishopm\base\Http\Controllers\RolesController@removepermission','as' => 'admin.roles.removepermission']);

		// Settings
		Route::get('admin/settings',['uses'=>'bishopm\base\Http\Controllers\SettingsController@index','as'=>'admin.settings.index']);
		Route::get('admin/settings/create',['uses'=>'bishopm\base\Http\Controllers\SettingsController@create','as'=>'admin.settings.create']);
		Route::get('admin/settings/{setting}',['uses'=>'bishopm\base\Http\Controllers\SettingsController@show','as'=>'admin.settings.show']);
		Route::get('admin/settings/{setting}/edit',['uses'=>'bishopm\base\Http\Controllers\SettingsController@edit','as'=>'admin.settings.edit']);
		Route::put('admin/settings/{setting}',['uses'=>'bishopm\base\Http\Controllers\SettingsController@update','as'=>'admin.settings.update']);
		Route::post('admin/settings',['uses'=>'bishopm\base\Http\Controllers\SettingsController@store','as'=>'admin.settings.store']);
	    Route::delete('admin/settings/{setting}',['uses'=>'bishopm\base\Http\Controllers\SettingsController@destroy','as'=>'admin.settings.destroy']);

		// Users
		Route::get('admin/users',['uses'=>'bishopm\base\Http\Controllers\UsersController@index','as'=>'admin.users.index']);
		Route::get('admin/users/create',['uses'=>'bishopm\base\Http\Controllers\UsersController@create','as'=>'admin.users.create']);
		Route::get('admin/users/{user}',['uses'=>'bishopm\base\Http\Controllers\UsersController@show','as'=>'admin.users.show']);
		Route::get('admin/users/{user}/edit',['uses'=>'bishopm\base\Http\Controllers\UsersController@edit','as'=>'admin.users.edit']);
		Route::put('admin/users/{user}',['uses'=>'bishopm\base\Http\Controllers\UsersController@update','as'=>'admin.users.update']);
		Route::post('admin/users',['uses'=>'bishopm\base\Http\Controllers\UsersController@store','as'=>'admin.users.store']);
	    Route::delete('admin/users/{user}',['uses'=>'bishopm\base\Http\Controllers\UsersController@destroy','as'=>'admin.users.destroy']);

	});
});

Route::any('{uri}', ['uses' => 'bishopm\base\Http\Controllers\WebController@uri','as' => 'page',       'middleware' => 'web',])->where('uri', '.*');


/*
|        | POST     | password/email                    |                        | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web,guest    |
|        | GET|HEAD | password/reset                    |                        | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web,guest    |
|        | POST     | password/reset                    |                        | App\Http\Controllers\Auth\ResetPasswordController@reset                | web,guest    |
|        | GET|HEAD | password/reset/{token}            |                        | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web,guest    |
|        | GET|HEAD | register                          | register               | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web,guest    |
|        | POST     | register                          |                        | App\Http\Controllers\Auth\RegisterController@register                  | web,guest    |
*/
