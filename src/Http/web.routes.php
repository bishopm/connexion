<?php

Route::group(['middleware' => ['web']], function () {
    // Authentication for guests
    Route::get('/feed/{service?}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@feed','as' => 'feed']);
    Route::get('/journeyfeed', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@journeyfeed','as' => 'journeyfeed']);
    Route::get('/sermonfeed', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@sermonfeed','as' => 'sermonfeed']);
    Route::get('/blogfeed', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@blogfeed','as' => 'blogfeed']);
    Route::get('login', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\LoginController@showLoginForm','as'=>'showlogin']);
    Route::post('login', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\LoginController@login','as'=>'login']);
    // Social login
    Route::get('/login/{social}', 'Bishopm\Connexion\Http\Controllers\Auth\LoginController@socialLogin')->where('social', 'facebook|google');
    Route::get('/login/{social}/callback', 'Bishopm\Connexion\Http\Controllers\Auth\LoginController@handleProviderCallback')->where('social', 'facebook|google');

    Route::post('password/email', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail','as'=>'sendResetLinkEmail']);
    Route::get('password/reset', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm','as'=>'showLinkRequestForm']);
    Route::post('password/reset', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\ResetPasswordController@reset','as'=>'password.reset']);
    Route::get('password/reset/{token}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\ResetPasswordController@showResetForm','as'=>'showResetForm']);
    if ((\Illuminate\Support\Facades\Schema::hasTable('settings')) and (in_array('website', Setting::activemodules()))) {
        Route::get('/', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@home','as' => 'homepage']);
        Route::get('/blog/{year}/{month?}/{slug?}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webblog','as' => 'webblog']);
        Route::get('/blog', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webblogs','as' => 'webblogs']);
        Route::get('/people/{slug}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webperson','as' => 'webperson']);
        Route::get('/subject/{tag}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@websubject','as' => 'websubject']);
        Route::get('/sermons/{series}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webseries','as' => 'webseries']);
        Route::get('/sermons/{series}/{sermon}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@websermon','as' => 'websermon']);
        Route::get('/sermons', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@websermons','as' => 'websermons']);
        Route::get('/course/{course}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\CoursesController@show','as'=>'webresource']);
        Route::get('/coming-up/{event}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@webevent','as'=>'webevent']);
        Route::get('/coming-up', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@comingup','as'=>'comingup']);
        Route::get('/course/{course}/sign-up', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\CoursesController@signup','as'=>'coursesignup']);
        Route::get('/event/{course}/sign-up', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\EventsController@showsignup','as'=>'eventsignup']);
        Route::post('/admin/events/{event}/signup', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\EventsController@signup','as' => 'admin.events.signup']);
        Route::get('courses', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@webcourses','as'=>'webcourses']);
        Route::get('book/{book}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BooksController@show','as'=>'webbook']);
        Route::get('books', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@webbooks','as'=>'webbooks']);
        Route::get('/author/{author}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webauthor','as' => 'webauthor']);
        Route::get('register', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\RegisterController@showRegistrationForm','as'=>'registrationform']);
        Route::post('register', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\RegisterController@register','as'=>'admin.register']);
        Route::post('checkmail', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@checkEmail','as'=>'checkmail']);
        Route::get('admin/newuser/checkname/{username}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@checkname','as'=>'admin.checkname']);
        Route::post('admin/newuser', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@newuser','as'=>'admin.newuser']);
        Route::get('admin/getusername/{email}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@getusername','as'=>'admin.getusername']);
        Route::get('/groups/{category}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webgroupcategory','as' => 'webgroupcategory']);
        Route::get('/groups', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@weballgroups','as' => 'weballgroups']);
        Route::get('/group/{slug}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webgroup','as' => 'webgroup']);
        Route::get('/lectionary', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@lectionary','as' => 'lectionary']);
        Route::get('/my-church', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@mychurch','as' => 'mychurch']);
        Route::get('/my-details', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@mydetails','as' => 'mydetails']);
        Route::get('/my-giving', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@mygiving','as' => 'mygiving']);
        Route::get('/register-user', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@registeruser','as' => 'registeruser']);
    }
    Route::group(['middleware' => ['web','isverified','can:edit-comments']], function () {
        //Webuser routes
        Route::post('/comments', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@deletecomment','as' => 'deletecomment']);
        Route::get('/users/{slug}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webuser','as' => 'webuser']);
        Route::get('/rosters/{roster}/current', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RostersController@currentroster','as'=>'rosters.current']);
        Route::get('/rosters/{roster}/next', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RostersController@nextroster','as'=>'rosters.next']);
        Route::get('/users/{slug}/edit', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webuseredit','as' => 'webuser.edit']);
        Route::post('/users/{user}/message', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@usermessage','as' => 'usermessage']);
        Route::get('/my-details/householdedit', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webuserhouseholdedit','as' => 'webuser.household.edit']);
        Route::get('/my-details/edit/{slug}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webuserindividualedit','as' => 'webuser.individual.edit']);
        Route::get('/my-details/add-individual', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webuserindividualadd','as' => 'webuser.individual.create']);
        Route::get('/my-details/edit-anniversary/{ann}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webuseranniversaryedit','as' => 'webuser.anniversary.edit']);
        Route::get('/my-details/add-anniversary', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webuseranniversaryadd','as' => 'webuser.anniversary.add']);
        Route::post('/admin/groups/{group}/signup', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\GroupsController@signup','as' => 'admin.groups.signup']);
        Route::post('admin/blogs/{blog}/addcomment', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\BlogsController@addcomment','as' => 'admin.blogs.addcomment']);
        Route::post('admin/books/{book}/addcomment', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\BooksController@addcomment','as' => 'admin.books.addcomment']);
        Route::post('admin/courses/{course}/addcomment', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\CoursesController@addcomment','as' => 'admin.courses.addcomment']);
        Route::post('admin/series/{series}/sermons/{sermon}/addcomment', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\SermonsController@addcomment','as' => 'admin.sermons.addcomment']);
        Route::put('admin/users/{user}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\UsersController@update','as'=>'admin.users.update']);
        Route::get('admin/individuals/{individual}/removemedia', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@removemedia','as'=>'admin.individuals.removemedia']);
        Route::put('admin/households/{household}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\HouseholdsController@update','as'=>'admin.households.update']);
        Route::put('admin/households/{household}/individuals/{individual}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@update','as'=>'admin.individuals.update']);
        Route::get('admin/households/{household}/individuals/{individual}/giving/{pg}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@giving','as'=>'admin.individuals.giving']);
        Route::put('admin/households/{household}/specialdays', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\SpecialdaysController@update','as' => 'admin.specialdays.update']);
        Route::post('admin/households/{household}/specialdays', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\SpecialdaysController@store','as' => 'admin.specialdays.store']);
        Route::post('admin/households/{household}/individuals', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@store','as'=>'admin.individuals.store']);
        Route::post('admin/updateimage/{entity}/{individual?}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@updateimage','as'=>'admin.individuals.updateimage']);
        Route::get('/group/{slug}/edit', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@webgroupedit','as' => 'webgroupedit']);
        Route::get('admin/groups/{group}/addmember/{member}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\GroupsController@addmember','as' => 'admin.groups.addmember']);
        Route::get('admin/groups/{group}/removemember/{member}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\GroupsController@removemember','as' => 'admin.groups.removemember']);

        // Forum posts
        Route::get('forum', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PostsController@index','as'=>'posts.index']);
        Route::get('forum/newpost', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PostsController@create','as'=>'posts.create']);
        Route::get('forum/posts/{post}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PostsController@edit','as'=>'posts.edit']);
        Route::get('forum/posts/{post}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PostsController@show','as'=>'posts.show']);
        Route::put('forum/posts/{post}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PostsController@update','as'=>'posts.update']);
        Route::post('forum/posts', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PostsController@store','as'=>'posts.store']);
        Route::delete('forum/posts/{post}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PostsController@destroy','as'=>'posts.destroy']);
    });
});

Route::get('email-verification/error', 'Bishopm\Connexion\Http\Controllers\Auth\RegisterController@getVerificationError')->name('email-verification.error');
Route::get('email-verification/check/{token}', 'Bishopm\Connexion\Http\Controllers\Auth\RegisterController@getVerification')->name('email-verification.check');

Route::group(['middleware' => 'web'], function () {
    // Logout
    Route::post('logout', ['uses'=>'Bishopm\Connexion\Http\Controllers\Auth\LoginController@logout','as'=>'logout']);
});

Route::group(['middleware' => ['web','isverified','can:view-backend']], function () {
    // Setitems
    Route::get('admin/worship/addsetitem/{set}/{song}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ServicesController@index','as'=>'admin.services.index']);
    Route::get('admin/worship/addsetitem/{set}/{song}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SetitemsController@additem','as'=>'admin.setitems.add']);
    Route::post('admin/worship/addorderitem/', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SetitemsController@addorderitem','as'=>'admin.orderitems.add']);
    Route::get('admin/worship/getitems/{set}', 'Bishopm\Connexion\Http\Controllers\Web\SetitemsController@getitems');
    Route::get('admin/worship/getmessage/{set}', 'Bishopm\Connexion\Http\Controllers\Web\SetitemsController@getmessage');
    Route::post('admin/worship/reorderset/{set}', 'Bishopm\Connexion\Http\Controllers\Web\SetitemsController@reorderset');
    Route::get('admin/worship/deletesetitem/{setitem}', 'Bishopm\Connexion\Http\Controllers\Web\SetitemsController@deleteitem');

    // Sets
    Route::get('admin/worship/sets', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SetsController@index','as'=>'admin.sets.index']);
    Route::get('admin/worship/sets/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SetsController@create','as'=>'admin.sets.create']);
    Route::post('admin/worship/sets', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SetsController@store','as'=>'admin.sets.store']);
    Route::post('admin/worship/sets/duplicate', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SetsController@duplicatestore','as'=>'admin.sets.duplicatestore']);
    Route::get('admin/worship/sets/{set}/duplicate', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SetsController@duplicate','as'=>'admin.sets.duplicate']);
    Route::get('admin/worship/sets/{set}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SetsController@edit','as'=>'admin.sets.edit']);
    Route::get('admin/worship/sets/{set}/order', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SetsController@order','as'=>'admin.sets.order']);
    Route::get('admin/worship/sets/{set}/{mode?}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SetsController@show','as'=>'admin.sets.show']);
    Route::get('admin/worship/setsapi/{set}', 'Bishopm\Connexion\Http\Controllers\Web\SetsController@showapi');
    Route::put('admin/worship/sets/{set}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SetsController@update','as'=>'admin.sets.update']);
    Route::put('admin/worship/setsapi/{set}', 'Bishopm\Connexion\Http\Controllers\Web\SetsController@updateapi');
    Route::delete('admin/worship/sets/{set}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SetsController@destroy','as'=>'admin.sets.destroy']);
    Route::post('admin/worship/sets/sendemail', 'Bishopm\Connexion\Http\Controllers\Web\SetsController@sendEmail');

    // Songs
    Route::get('admin/worship/songs', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SongsController@index','as'=>'admin.songs.index']);
    Route::get('admin/worship/songs/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SongsController@create','as'=>'admin.songs.create']);
    Route::get('admin/worship/liturgy/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SongsController@createliturgy','as'=>'admin.liturgy.create']);
    Route::post('admin/worship/songs', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SongsController@store','as'=>'admin.songs.store']);
    Route::get('admin/worship/songs/{song}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SongsController@edit','as'=>'admin.songs.edit']);
    Route::get('admin/worship/songs/{song}/{mode?}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SongsController@show','as'=>'admin.songs.show']);
    Route::get('admin/worship/songapi/{song}', 'Bishopm\Connexion\Http\Controllers\Web\SongsController@showapi');
    Route::put('admin/worship/songs/{song}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SongsController@update','as'=>'admin.songs.update']);
    Route::delete('admin/worship/songs/{song}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SongsController@destroy','as'=>'admin.songs.destroy']);
    Route::post('admin/worship/search', 'Bishopm\Connexion\Http\Controllers\Web\SongsController@search');

    Route::post('admin/worship/convert', 'Bishopm\Connexion\Http\Controllers\Web\SongsController@convert');
    Route::get('admin/worship', 'Bishopm\Connexion\Http\Controllers\Web\SongsController@index');
    
    //Images
    Route::post('admin/addimage', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@addimage','as'=>'admin.addimage']);
    Route::post('admin/search', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@search','as'=>'admin.search']);
    // Dashboard
    Route::get('admin', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@dashboard','as'=>'dashboard']);
    Route::get('home', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\WebController@dashboard','as'=>'dashboard']);

    // Actions
    Route::get('admin/actions', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ActionsController@index','as'=>'admin.actions.index']);
    Route::get('admin/actions/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ActionsController@generalcreate','as'=>'admin.actions.general.create']);
    Route::get('admin/projects/{project}/actions/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ActionsController@create','as'=>'admin.actions.create']);
    Route::get('admin/actions/{action}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ActionsController@show','as'=>'admin.actions.show']);
    Route::get('admin/actions/{action}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ActionsController@edit','as'=>'admin.actions.edit']);
    Route::put('admin/actions/{action}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ActionsController@update','as'=>'admin.actions.update']);
    Route::post('admin/projects/actions', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ActionsController@generalstore','as'=>'admin.actions.general.store']);
    Route::post('admin/projects/{project}/actions', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ActionsController@store','as'=>'admin.actions.store']);
    Route::delete('admin/actions/{action}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ActionsController@destroy','as'=>'admin.actions.destroy']);
    Route::get('admin/actions/addtag/{action}/{tag}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\ActionsController@addtag','as' => 'admin.actions.addtag']);
    Route::get('admin/actions/removetag/{action}/{tag}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\ActionsController@removetag','as' => 'admin.actions.removetag']);
    Route::get('admin/actions/togglecompleted/{action}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\ActionsController@togglecompleted','as' => 'admin.actions.togglecompleted']);

    // Blocks
    Route::get('admin/blocks', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlocksController@index','as'=>'admin.blocks.index']);
    Route::get('admin/blocks/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlocksController@create','as'=>'admin.blocks.create']);
    Route::get('admin/blocks/{block}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlocksController@show','as'=>'admin.blocks.show']);
    Route::get('admin/blocks/{block}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlocksController@edit','as'=>'admin.blocks.edit']);
    Route::put('admin/blocks/{block}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlocksController@update','as'=>'admin.blocks.update']);
    Route::post('admin/blocks', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlocksController@store','as'=>'admin.blocks.store']);
    Route::delete('admin/blocks/{block}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlocksController@destroy','as'=>'admin.blocks.destroy']);

    // Blogs
    Route::get('admin/blogs', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlogsController@index','as'=>'admin.blogs.index']);
    Route::get('admin/blogs/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlogsController@create','as'=>'admin.blogs.create']);
    Route::get('admin/blogs/{blog}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlogsController@show','as'=>'admin.blogs.show']);
    Route::get('admin/blogs/{blog}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlogsController@edit','as'=>'admin.blogs.edit']);
    Route::put('admin/blogs/{blog}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlogsController@update','as'=>'admin.blogs.update']);
    Route::post('admin/blogs', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlogsController@store','as'=>'admin.blogs.store']);
    Route::delete('admin/blogs/{blog}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlogsController@destroy','as'=>'admin.blogs.destroy']);
    Route::get('admin/blogs/addtag/{blog}/{tag}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\BlogsController@addtag','as' => 'admin.blogs.addtag']);
    Route::get('admin/blogs/removetag/{blog}/{tag}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\BlogsController@removetag','as' => 'admin.blogs.removetag']);
    Route::get('admin/blogs/{blog}/removemedia', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BlogsController@removemedia','as'=>'admin.blogs.removemedia']);

    // Books
    Route::get('admin/books', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BooksController@index','as'=>'admin.books.index']);
    Route::get('admin/books/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BooksController@create','as'=>'admin.books.create']);
    Route::get('admin/books/{book}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BooksController@edit','as'=>'admin.books.edit']);
    Route::put('admin/books/{book}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BooksController@update','as'=>'admin.books.update']);
    Route::post('admin/books', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BooksController@store','as'=>'admin.books.store']);
    Route::delete('admin/books/{book}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BooksController@destroy','as'=>'admin.books.destroy']);
    Route::get('admin/books/addtag/{book}/{tag}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\BooksController@addtag','as' => 'admin.books.addtag']);
    Route::get('admin/books/removetag/{book}/{tag}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\BooksController@removetag','as' => 'admin.books.removetag']);
    Route::get('admin/books/getbook/{book}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BooksController@getbook','as'=>'admin.books.getbook']);
    Route::post('admin/books/placeorder', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\BooksController@placeorder','as'=>'admin.books.placeorder']);

    // Chords
    Route::get('admin/worship/chords', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GchordsController@index','as'=>'admin.chords.index']);
    Route::get('admin/worship/chords/create/{name?}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GchordsController@create','as'=>'admin.chords.create']);
    Route::post('admin/worship/chords', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GchordsController@store','as'=>'admin.chords.store']);
    Route::get('admin/worship/chords/{chord}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GchordsController@edit','as'=>'admin.chords.edit']);
    Route::get('admin/worship/chords/{chord}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GchordsController@show','as'=>'admin.chords.show']);
    Route::put('admin/worship/chords/{chord}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GchordsController@update','as'=>'admin.chords.update']);
    Route::delete('admin/worship/chords/{chord}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GchordsController@destroy','as'=>'admin.chords.destroy']);

    // Courses
    Route::get('admin/courses', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\CoursesController@index','as'=>'admin.courses.index']);
    Route::get('admin/courses/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\CoursesController@create','as'=>'admin.courses.create']);
    Route::get('admin/courses/{course}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\CoursesController@edit','as'=>'admin.courses.edit']);
    Route::put('admin/courses/{course}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\CoursesController@update','as'=>'admin.courses.update']);
    Route::post('admin/courses', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\CoursesController@store','as'=>'admin.courses.store']);
    Route::delete('admin/courses/{course}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\CoursesController@destroy','as'=>'admin.courses.destroy']);

    // Events
    Route::get('admin/events', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\EventsController@index','as'=>'admin.events.index']);
    Route::get('admin/events/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\EventsController@create','as'=>'admin.events.create']);
    Route::get('admin/events/{event}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\EventsController@show','as'=>'admin.events.show']);
    Route::get('admin/events/{event}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\EventsController@edit','as'=>'admin.events.edit']);
    Route::put('admin/events/{event}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\EventsController@update','as'=>'admin.events.update']);
    Route::post('admin/events', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\EventsController@store','as'=>'admin.events.store']);
    Route::delete('admin/events/{event}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\EventsController@destroy','as'=>'admin.events.destroy']);

    // Folders
    Route::get('admin/folders', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\FoldersController@index','as'=>'admin.folders.index']);
    Route::get('admin/folders/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\FoldersController@create','as'=>'admin.folders.create']);
    Route::get('admin/folders/{folder}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\FoldersController@show','as'=>'admin.folders.show']);
    Route::get('admin/folders/{folder}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\FoldersController@edit','as'=>'admin.folders.edit']);
    Route::put('admin/folders/{folder}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\FoldersController@update','as'=>'admin.folders.update']);
    Route::post('admin/folders', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\FoldersController@store','as'=>'admin.folders.store']);
    Route::delete('admin/folders/{folder}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\FoldersController@destroy','as'=>'admin.folders.destroy']);

    // Groups
    Route::get('admin/groups', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GroupsController@index','as'=>'admin.groups.index']);
    Route::get('admin/groups/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GroupsController@create','as'=>'admin.groups.create']);
    Route::get('admin/groups/{group}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GroupsController@show','as'=>'admin.groups.show']);
    Route::get('admin/groups/{group}/report', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GroupsController@report','as'=>'admin.groups.report']);
    Route::get('admin/groups/{group}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GroupsController@edit','as'=>'admin.groups.edit']);
    Route::put('admin/groups/{group}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GroupsController@update','as'=>'admin.groups.update']);
    Route::post('admin/groups', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GroupsController@store','as'=>'admin.groups.store']);
    Route::delete('admin/groups/{group}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\GroupsController@destroy','as'=>'admin.groups.destroy']);

    // Households
    Route::get('admin/households', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\HouseholdsController@index','as'=>'admin.households.index']);
    Route::get('admin/households/report/{individual?}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\HouseholdsController@report','as'=>'admin.households.report']);
    Route::get('admin/households/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\HouseholdsController@create','as'=>'admin.households.create']);
    Route::get('admin/households/{household}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\HouseholdsController@show','as'=>'admin.households.show']);
    Route::get('admin/households/{household}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\HouseholdsController@edit','as'=>'admin.households.edit']);
    Route::post('admin/households', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\HouseholdsController@store','as'=>'admin.households.store']);
    Route::delete('admin/households/{household}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\HouseholdsController@destroy','as'=>'admin.households.destroy']);

    // Individuals
    Route::get('admin/households/{household}/individuals/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@create','as'=>'admin.individuals.create']);
    Route::get('admin/households/{household}/individuals/{individual}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@show','as'=>'admin.individuals.show']);
    Route::get('admin/households/{household}/individuals/{individual}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@edit','as'=>'admin.individuals.edit']);
    Route::delete('admin/households/{household}/individuals/{individual}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@destroy','as'=>'admin.individuals.destroy']);
    Route::get('admin/individuals/addgroup/{member}/{group}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@addgroup','as' => 'admin.individuals.addgroup']);
    Route::get('admin/individuals/removegroup/{member}/{group}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@removegroup','as' => 'admin.individuals.removegroup']);
    Route::get('admin/individuals/addtag/{member}/{tag}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@addtag','as' => 'admin.individuals.addtag']);
    Route::get('admin/individuals/removetag/{member}/{tag}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\IndividualsController@removetag','as' => 'admin.individuals.removetag']);

    // Menus
    Route::get('admin/menus', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenusController@index','as'=>'admin.menus.index']);
    Route::get('admin/menus/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenusController@create','as'=>'admin.menus.create']);
    Route::get('admin/menus/{menu}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenusController@show','as'=>'admin.menus.show']);
    Route::get('admin/menus/{menu}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenusController@edit','as'=>'admin.menus.edit']);
    Route::put('admin/menus/{menu}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenusController@update','as'=>'admin.menus.update']);
    Route::post('admin/menus', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenusController@store','as'=>'admin.menus.store']);
    Route::delete('admin/menus/{menu}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenusController@destroy','as'=>'admin.menus.destroy']);

    // Menuitems
    Route::get('admin/menus/{menu}/menuitems', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenuitemsController@index','as'=>'admin.menuitems.index']);
    Route::get('admin/menus/{menu}/menuitems/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenuitemsController@create','as'=>'admin.menuitems.create']);
    Route::get('admin/menus/{menu}/menuitems/{menuitem}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenuitemsController@show','as'=>'admin.menuitems.show']);
    Route::get('admin/menus/{menu}/menuitems/{menuitem}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenuitemsController@edit','as'=>'admin.menuitems.edit']);
    Route::put('admin/menus/{menu}/menuitems/{menuitem}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenuitemsController@update','as'=>'admin.menuitems.update']);
    Route::post('admin/menus/{menu}/menuitems', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenuitemsController@store','as'=>'admin.menuitems.store']);
    Route::post('admin/menus/{menu}/menuitems/update', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenuitemsController@reorder','as'=>'admin.menuitems.reorder']);
    Route::delete('admin/menus/{menu}/menuitems/{menuitem}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MenuitemsController@destroy','as'=>'admin.menuitems.destroy']);

    // Messages
    Route::get('admin/messages/create/{group?}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MessagesController@create','as'=>'admin.messages.create']);
    Route::post('admin/messages', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\MessagesController@store','as'=>'admin.messages.store']);

    // Modules
    Route::get('admin/modules/{module}/toggle', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@modulestoggle','as'=>'admin.modules.index']);
    Route::get('admin/modules', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@modulesindex','as'=>'admin.modules.index']);

    // Pages
    Route::get('admin/pages', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PagesController@index','as'=>'admin.pages.index']);
    Route::get('admin/pages/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PagesController@create','as'=>'admin.pages.create']);
    Route::get('admin/pages/{page}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PagesController@show','as'=>'admin.pages.show']);
    Route::get('admin/pages/{page}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PagesController@edit','as'=>'admin.pages.edit']);
    Route::put('admin/pages/{page}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PagesController@update','as'=>'admin.pages.update']);
    Route::post('admin/pages', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PagesController@store','as'=>'admin.pages.store']);
    Route::delete('admin/pages/{page}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PagesController@destroy','as'=>'admin.pages.destroy']);

    // Pastorals
    Route::get('admin/households/{household}/pastorals', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\PastoralsController@index','as' => 'admin.pastorals.index']);
    Route::post('admin/households/{household}/pastorals', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\PastoralsController@store','as' => 'admin.pastorals.store']);
    Route::put('admin/households/{household}/pastorals', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\PastoralsController@update','as' => 'admin.pastorals.update']);
    Route::delete('admin/households/{household}/pastorals/{pastoral}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\PastoralsController@destroy','as' => 'admin.pastorals.destroy']);

    Route::group(['middleware' => ['web','can:admin-giving']], function () {
        // Payments
        Route::get('admin/payments', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PaymentsController@index','as'=>'admin.payments.index']);
        Route::get('admin/payments/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PaymentsController@create','as'=>'admin.payments.create']);
        Route::get('admin/payments/{payment}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PaymentsController@show','as'=>'admin.payments.show']);
        Route::get('admin/payments/monthtotals/{year}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PaymentsController@monthtotals','as'=>'admin.payments.monthtotals']);
        Route::get('admin/payments/{payment}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PaymentsController@edit','as'=>'admin.payments.edit']);
        Route::put('admin/payments/{payment}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PaymentsController@update','as'=>'admin.payments.update']);
        Route::post('admin/payments', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PaymentsController@store','as'=>'admin.payments.store']);
        Route::delete('admin/payments/{payment}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PaymentsController@destroy','as'=>'admin.payments.destroy']);
    });

    // Projects
    Route::get('admin/projects', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ProjectsController@index','as'=>'admin.projects.index']);
    Route::get('admin/projects/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ProjectsController@create','as'=>'admin.projects.create']);
    Route::get('admin/projects/{project}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ProjectsController@show','as'=>'admin.projects.show']);
    Route::get('admin/projects/{project}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ProjectsController@edit','as'=>'admin.projects.edit']);
    Route::put('admin/projects/{project}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ProjectsController@update','as'=>'admin.projects.update']);
    Route::post('admin/projects', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ProjectsController@store','as'=>'admin.projects.store']);
    Route::delete('admin/projects/{project}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ProjectsController@destroy','as'=>'admin.projects.destroy']);

    // Readings
    Route::get('admin/readings', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ReadingsController@index','as'=>'admin.readings.index']);
    Route::get('admin/readings/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ReadingsController@create','as'=>'admin.readings.create']);
    Route::get('admin/readings/{reading}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ReadingsController@show','as'=>'admin.readings.show']);
    Route::get('admin/readings/monthtotals/{year}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ReadingsController@monthtotals','as'=>'admin.readings.monthtotals']);
    Route::get('admin/readings/{reading}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ReadingsController@edit','as'=>'admin.readings.edit']);
    Route::put('admin/readings/{reading}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ReadingsController@update','as'=>'admin.readings.update']);
    Route::post('admin/readings', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ReadingsController@store','as'=>'admin.readings.store']);
    Route::delete('admin/readings/{reading}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\ReadingsController@destroy','as'=>'admin.readings.destroy']);

    // Rosters
    Route::group(['middleware' => ['web','can:edit-roster']], function () {
        Route::get('admin/rosters', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RostersController@index','as'=>'admin.rosters.index']);
        Route::group(['middleware' => ['web','can:edit-backend']], function () {
            Route::get('admin/rosters/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RostersController@create','as'=>'admin.rosters.create']);
            Route::post('admin/rosters', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RostersController@store','as'=>'admin.rosters.store']);
            Route::get('admin/rosters/{group}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RostersController@show','as'=>'admin.rosters.show']);
            Route::get('admin/rosters/{group}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RostersController@edit','as'=>'admin.rosters.edit']);
            Route::put('admin/rosters/{group}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RostersController@update','as'=>'admin.rosters.update']);
            Route::delete('admin/rosters/{group}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RostersController@destroy','as'=>'admin.rosters.destroy']);
            Route::post('admin/rosters/{rosters}/sms/{send}', 'Bishopm\Connexion\Http\Controllers\Web\RostersController@sms');
        });
        Route::get('admin/rosters/{rosters}/{year}/{month}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RostersController@details','as'=>'admin.rosters.details']);
        Route::post('admin/rosters/{rosters}/revise', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RostersController@revise','as'=>'admin.rosters.revise']);
    });
    Route::get('/admin/rosters/{roster}/report/{year}/{month}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RostersController@report','as'=>'admin.rosters.report']);

    // Series
    Route::get('admin/series', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SeriesController@index','as'=>'admin.series.index']);
    Route::get('admin/series/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SeriesController@create','as'=>'admin.series.create']);
    Route::get('admin/series/{series}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SeriesController@show','as'=>'admin.series.show']);
    Route::get('admin/series/{series}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SeriesController@edit','as'=>'admin.series.edit']);
    Route::put('admin/series/{series}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SeriesController@update','as'=>'admin.series.update']);
    Route::post('admin/series', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SeriesController@store','as'=>'admin.series.store']);
    Route::delete('admin/series/{series}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SeriesController@destroy','as'=>'admin.series.destroy']);

    // Sermons
    Route::get('admin/series/{series}/sermons', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SermonsController@index','as'=>'admin.sermons.index']);
    Route::get('admin/series/{series}/sermons/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SermonsController@create','as'=>'admin.sermons.create']);
    Route::get('admin/series/{series}/sermons/{sermon}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SermonsController@show','as'=>'admin.sermons.show']);
    Route::get('admin/series/{series}/sermons/{sermon}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SermonsController@edit','as'=>'admin.sermons.edit']);
    Route::put('admin/series/{series}/sermons/{sermon}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SermonsController@update','as'=>'admin.sermons.update']);
    Route::post('admin/series/{series}/sermons', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SermonsController@store','as'=>'admin.sermons.store']);
    Route::delete('admin/series/{series}/sermons/{sermon}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SermonsController@destroy','as'=>'admin.sermons.destroy']);
    Route::get('admin/sermons/addtag/{sermon}/{tag}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\SermonsController@addtag','as' => 'admin.sermons.addtag']);
    Route::get('admin/sermons/removetag/{sermon}/{tag}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\SermonsController@removetag','as' => 'admin.sermons.removetag']);

    // Slides
    Route::get('admin/slides', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlidesController@index','as'=>'admin.slides.index']);
    Route::get('admin/slideshows/{slideshow}/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlidesController@create','as'=>'admin.slides.create']);
    Route::get('admin/slides/{slide}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlidesController@show','as'=>'admin.slides.show']);
    Route::get('admin/slideshows/{slideshow}/slides/{slide}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlidesController@edit','as'=>'admin.slides.edit']);
    Route::put('admin/slides/{slide}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlidesController@update','as'=>'admin.slides.update']);
    Route::post('admin/slides', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlidesController@store','as'=>'admin.slides.store']);
    Route::delete('admin/slides/{slide}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlidesController@destroy','as'=>'admin.slides.destroy']);

    // Slideshows
    Route::get('admin/slideshows', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlideshowsController@index','as'=>'admin.slideshows.index']);
    Route::get('admin/slideshows/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlideshowsController@create','as'=>'admin.slideshows.create']);
    Route::get('admin/slideshows/{slideshow}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlideshowsController@show','as'=>'admin.slideshows.show']);
    Route::get('admin/slideshows/{slideshow}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlideshowsController@edit','as'=>'admin.slideshows.edit']);
    Route::put('admin/slideshows/{slideshow}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlideshowsController@update','as'=>'admin.slideshows.update']);
    Route::post('admin/slideshows', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlideshowsController@store','as'=>'admin.slideshows.store']);
    Route::delete('admin/slideshows/{slideshow}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SlideshowsController@destroy','as'=>'admin.slideshows.destroy']);

    // Specialdays
    Route::get('admin/households/{household}/specialdays', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\SpecialdaysController@index','as' => 'admin.specialdays.index']);
    Route::delete('admin/households/{household}/specialdays/{specialday}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\SpecialdaysController@destroy','as' => 'admin.specialdays.destroy']);

    // Staff
    Route::get('admin/staff', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StaffController@index','as'=>'admin.staff.index']);
    Route::get('admin/staff/create/{individual}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StaffController@create','as'=>'admin.staff.create']);
    Route::post('admin/staff', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StaffController@store','as'=>'admin.staff.store']);
    Route::post('admin/staff/leave', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StaffController@addleave','as'=>'admin.staff.addleave']);
    Route::get('admin/staff/{id}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StaffController@edit','as'=>'admin.staff.edit']);
    Route::put('admin/staff/{id}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StaffController@update','as'=>'admin.staff.update']);
    Route::get('admin/staff/{slug}/{year?}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StaffController@show','as'=>'admin.staff.show']);

    // Statistics
    Route::get('admin/statistics', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StatisticsController@index','as'=>'admin.statistics.index']);
    Route::get('admin/statistics/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StatisticsController@create','as'=>'admin.statistics.create']);
    Route::get('admin/statistics/graph/{year?}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StatisticsController@showgraph','as'=>'admin.statistics.graph']);
    Route::get('admin/statistics/historygraph/{service}/{years?}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StatisticsController@showhistory','as'=>'admin.statistics.historygraph']);
    Route::get('admin/statistics/{statistic}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StatisticsController@show','as'=>'admin.statistics.show']);
    Route::get('admin/statistics/{statistic}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StatisticsController@edit','as'=>'admin.statistics.edit']);
    Route::put('admin/statistics/{statistic}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StatisticsController@update','as'=>'admin.statistics.update']);
    Route::post('admin/statistics', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StatisticsController@store','as'=>'admin.statistics.store']);
    Route::delete('admin/statistics/{statistic}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\StatisticsController@destroy','as'=>'admin.statistics.destroy']);

    // Suppliers
    Route::get('admin/suppliers', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SuppliersController@index','as'=>'admin.suppliers.index']);
    Route::get('admin/suppliers/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SuppliersController@create','as'=>'admin.suppliers.create']);
    Route::get('admin/suppliers/{supplier}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SuppliersController@show','as'=>'admin.suppliers.show']);
    Route::get('admin/suppliers/{supplier}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SuppliersController@edit','as'=>'admin.suppliers.edit']);
    Route::put('admin/suppliers/{supplier}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SuppliersController@update','as'=>'admin.suppliers.update']);
    Route::post('admin/suppliers', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SuppliersController@store','as'=>'admin.suppliers.store']);
    Route::delete('admin/suppliers/{supplier}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SuppliersController@destroy','as'=>'admin.suppliers.destroy']);

    // Templates
    Route::get('admin/templates', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\TemplatesController@index','as'=>'admin.templates.index']);

    // Transactions
    Route::get('admin/transactions', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\TransactionsController@index','as'=>'admin.transactions.index']);
    Route::get('admin/transactions/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\TransactionsController@create','as'=>'admin.transactions.create']);
    Route::get('admin/transactions/summary', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\TransactionsController@summary','as'=>'admin.transactions.summary']);
    Route::get('admin/transactions/{transaction}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\TransactionsController@show','as'=>'admin.transactions.show']);
    Route::get('admin/transactions/{transaction}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\TransactionsController@edit','as'=>'admin.transactions.edit']);
    Route::put('admin/transactions/{transaction}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\TransactionsController@update','as'=>'admin.transactions.update']);
    Route::post('admin/transactions', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\TransactionsController@store','as'=>'admin.transactions.store']);
    Route::delete('admin/transactions/{transaction}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\TransactionsController@destroy','as'=>'admin.transactions.destroy']);

    Route::group(['middleware' => ['web','can:admin-backend']], function () {

        // Permissions
        Route::get('admin/permissions', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PermissionsController@index','as'=>'admin.permissions.index']);
        Route::get('admin/permissions/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PermissionsController@create','as'=>'admin.permissions.create']);
        Route::get('admin/permissions/{permission}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PermissionsController@show','as'=>'admin.permissions.show']);
        Route::get('admin/permissions/{permission}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PermissionsController@edit','as'=>'admin.permissions.edit']);
        Route::put('admin/permissions/{permission}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PermissionsController@update','as'=>'admin.permissions.update']);
        Route::post('admin/permissions', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PermissionsController@store','as'=>'admin.permissions.store']);
        Route::delete('admin/permissions/{permission}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\PermissionsController@destroy','as'=>'admin.permissions.destroy']);
        
        // Roles
        Route::get('admin/roles', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RolesController@index','as'=>'admin.roles.index']);
        Route::get('admin/roles/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RolesController@create','as'=>'admin.roles.create']);
        Route::get('admin/roles/{role}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RolesController@show','as'=>'admin.roles.show']);
        Route::get('admin/roles/{role}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RolesController@edit','as'=>'admin.roles.edit']);
        Route::put('admin/roles/{role}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RolesController@update','as'=>'admin.roles.update']);
        Route::post('admin/roles', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RolesController@store','as'=>'admin.roles.store']);
        Route::delete('admin/roles/{role}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\RolesController@destroy','as'=>'admin.roles.destroy']);
        
        // Settings
        Route::get('admin/settings', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@index','as'=>'admin.settings.index']);
        Route::get('admin/logs', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@userlogs','as'=>'admin.settings.logs']);
        Route::get('admin/settings/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@create','as'=>'admin.settings.create']);
        Route::get('admin/settings/{setting}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@show','as'=>'admin.settings.show']);
        Route::get('admin/settings/{setting}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@edit','as'=>'admin.settings.edit']);
        Route::get('admin/settings/{setting}/extedit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@extedit','as'=>'admin.settings.extedit']);
        Route::put('admin/settings/{setting}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@update','as'=>'admin.settings.update']);
        Route::put('admin/settings/ext/{setting}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@extupdate','as'=>'admin.settings.extupdate']);
        Route::post('admin/settings', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@store','as'=>'admin.settings.store']);
        Route::delete('admin/settings/{setting}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@destroy','as'=>'admin.settings.destroy']);
        Route::get('admin/analytics', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\SettingsController@analytics','as'=>'admin.settings.analytics']);

        // Users
        Route::get('admin/users', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\UsersController@index','as'=>'admin.users.index']);
        Route::get('admin/users/verify', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\UsersController@verify','as'=>'admin.users.verify']);
        Route::get('admin/users/verify/{user}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\UsersController@verified','as'=>'admin.users.verified']);
        Route::get('admin/users/activate', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\UsersController@activate','as'=>'admin.users.activate']);
        Route::get('admin/users/activate/{user}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\UsersController@activateuser','as'=>'admin.users.activateuser']);
        Route::get('admin/users/create', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\UsersController@create','as'=>'admin.users.create']);
        Route::get('admin/users/{user}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\UsersController@show','as'=>'admin.users.show']);
        Route::get('admin/users/{user}/edit', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\UsersController@edit','as'=>'admin.users.edit']);
        Route::post('admin/users', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\UsersController@store','as'=>'admin.users.store']);
        Route::delete('admin/users/{user}', ['uses'=>'Bishopm\Connexion\Http\Controllers\Web\UsersController@destroy','as'=>'admin.users.destroy']);
    });
});

Route::get('/generic', function () {
    $generic = new Illuminate\Http\Request();
    $generic->subject="subject";
    $generic->sender="bob@gmail.com";
    $generic->header="header";
    $generic->footer="footer";
    $generic->emailmessage="<i>message</i>";
    return new Bishopm\Connexion\Mail\GenericMail($generic);
});

if ((\Illuminate\Support\Facades\Schema::hasTable('settings')) and (in_array('website', Setting::activemodules()))) {
    Route::any('{uri}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Web\WebController@uri','as' => 'page','middleware' => ['web']])->where('uri', '.*');
}
