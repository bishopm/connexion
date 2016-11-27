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

	// Households
	Route::get('admin/households',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@index','as'=>'admin.households.index']);
	Route::get('admin/households/create',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@create','as'=>'admin.households.create']);
	Route::get('admin/households/{household}',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@show','as'=>'admin.households.show']);
	Route::get('admin/households/{household}/edit',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@edit','as'=>'admin.households.edit']);
	Route::put('admin/households/{household}',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@update','as'=>'admin.households.update']);
	Route::post('admin/households',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@store','as'=>'admin.households.store']);

	// Settings
	Route::get('admin/settings',['uses'=>'bishopm\base\Http\Controllers\SettingsController@index','as'=>'admin.settings.index']);
	Route::get('admin/settings/create',['uses'=>'bishopm\base\Http\Controllers\SettingsController@create','as'=>'admin.settings.create']);
	Route::get('admin/settings/{setting}',['uses'=>'bishopm\base\Http\Controllers\SettingsController@show','as'=>'admin.settings.show']);
	Route::get('admin/settings/{setting}/edit',['uses'=>'bishopm\base\Http\Controllers\SettingsController@edit','as'=>'admin.settings.edit']);
	Route::post('admin/settings',['uses'=>'bishopm\base\Http\Controllers\SettingsController@store','as'=>'admin.settings.store']);

	// Users
	Route::get('admin/users/{user}',['uses'=>'bishopm\base\Http\Controllers\UsersController@show','as'=>'admin.users.show']);
});



	/*  
	    Route::delete('{society}/households/{household}',['uses'=>'HouseholdsController@destroy','as'=>'society.households.destroy']);*/



/*
|        | POST     | password/email                    |                        | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web,guest    |
|        | GET|HEAD | password/reset                    |                        | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web,guest    |
|        | POST     | password/reset                    |                        | App\Http\Controllers\Auth\ResetPasswordController@reset                | web,guest    |
|        | GET|HEAD | password/reset/{token}            |                        | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web,guest    |
|        | GET|HEAD | register                          | register               | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web,guest    |
|        | POST     | register                          |                        | App\Http\Controllers\Auth\RegisterController@register                  | web,guest    |
*/




