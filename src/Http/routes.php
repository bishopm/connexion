<?php 

Route::group(['middleware' => ['web']], function () {
	Route::get('/', function () {
    	return view('base::welcome');
	});
	Route::get('login',['uses'=>'bishopm\base\Http\Controllers\Auth\LoginController@showLoginForm','as'=>'showlogin']);
	Route::post('login',['uses'=>'bishopm\base\Http\Controllers\Auth\LoginController@login','as'=>'login']);
});
Route::group(['middleware' => ['web','authadmin']], function () {

	// Dashboard
	Route::get('admin',['uses'=>'bishopm\base\Http\Controllers\WebController@dashboard','as'=>'dashboard']);

	// Logout
	Route::post('logout',['uses'=>'bishopm\base\Http\Controllers\Auth\LoginController@logout','as'=>'logout']);

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

	// Pastorals
    Route::get('admin/households/{household}/pastorals', ['uses' => 'bishopm\base\Http\Controllers\PastoralsController@index','as' => 'admin.pastorals.index']);
    Route::post('admin/households/{household}/pastorals', ['uses' => 'bishopm\base\Http\Controllers\PastoralsController@store','as' => 'admin.pastorals.store']);
    Route::put('admin/households/{household}/pastorals', ['uses' => 'bishopm\base\Http\Controllers\PastoralsController@update','as' => 'admin.pastorals.update']);
    Route::delete('admin/households/{household}/pastorals/{pastoral}', ['uses' => 'bishopm\base\Http\Controllers\PastoralsController@destroy','as' => 'admin.pastorals.destroy']);

	// Users
	Route::get('admin/users/{user}',['uses'=>'bishopm\base\Http\Controllers\UsersController@show','as'=>'admin.users.show']);

	// Settings
	Route::get('admin/settings',['uses'=>'bishopm\base\Http\Controllers\SettingsController@index','as'=>'admin.settings.index']);
	Route::get('admin/settings/create',['uses'=>'bishopm\base\Http\Controllers\SettingsController@create','as'=>'admin.settings.create']);
	Route::get('admin/settings/{setting}',['uses'=>'bishopm\base\Http\Controllers\SettingsController@show','as'=>'admin.settings.show']);
	Route::get('admin/settings/{setting}/edit',['uses'=>'bishopm\base\Http\Controllers\SettingsController@edit','as'=>'admin.settings.edit']);
	Route::post('admin/settings',['uses'=>'bishopm\base\Http\Controllers\SettingsController@store','as'=>'admin.settings.store']);

	// Specialdays
    Route::get('admin/households/{household}/specialdays', ['uses' => 'bishopm\base\Http\Controllers\SpecialdaysController@index','as' => 'admin.specialdays.index']);
    Route::post('admin/households/{household}/specialdays', ['uses' => 'bishopm\base\Http\Controllers\SpecialdaysController@store','as' => 'admin.specialdays.store']);
    Route::put('admin/households/{household}/specialdays', ['uses' => 'bishopm\base\Http\Controllers\SpecialdaysController@update','as' => 'admin.specialdays.update']);
    Route::delete('admin/households/{household}/specialdays/{specialday}', ['uses' => 'bishopm\base\Http\Controllers\SpecialdaysController@destroy','as' => 'admin.specialdays.destroy']);

	// Users
	Route::get('admin/users',['uses'=>'bishopm\base\Http\Controllers\UsersController@index','as'=>'admin.users.index']);
	Route::get('admin/users/create',['uses'=>'bishopm\base\Http\Controllers\UsersController@create','as'=>'admin.users.create']);
	Route::get('admin/users/{user}',['uses'=>'bishopm\base\Http\Controllers\UsersController@show','as'=>'admin.users.show']);
	Route::get('admin/users/{user}/edit',['uses'=>'bishopm\base\Http\Controllers\UsersController@edit','as'=>'admin.users.edit']);
	Route::put('admin/users/{user}',['uses'=>'bishopm\base\Http\Controllers\UsersController@update','as'=>'admin.users.update']);
	Route::post('admin/users',['uses'=>'bishopm\base\Http\Controllers\UsersController@store','as'=>'admin.users.store']);
    Route::delete('admin/users/{user}',['uses'=>'bishopm\base\Http\Controllers\UsersController@destroy','as'=>'admin.users.destroy']);


});

/*
|        | POST     | password/email                    |                        | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web,guest    |
|        | GET|HEAD | password/reset                    |                        | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web,guest    |
|        | POST     | password/reset                    |                        | App\Http\Controllers\Auth\ResetPasswordController@reset                | web,guest    |
|        | GET|HEAD | password/reset/{token}            |                        | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web,guest    |
|        | GET|HEAD | register                          | register               | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web,guest    |
|        | POST     | register                          |                        | App\Http\Controllers\Auth\RegisterController@register                  | web,guest    |
*/




