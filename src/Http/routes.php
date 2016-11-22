<?php 
Route::get('/', function () {
    return view('base::dashboard');
});

Route::group(array('middleware' => 'authadmin'), function () {
	Route::get('admin', function () {
	    return view('base::dashboard');
	});
	Route::get('admin/households',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@index','as'=>'admin.households.index']);
	Route::get('admin/households/{household}',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@show','as'=>'admin.households.show']);
	Route::get('admin/households/{household}/edit',['uses'=>'bishopm\base\Http\Controllers\HouseholdsController@edit','as'=>'admin.households.edit']);


	/*    Route::get('{society}/households/create',['uses'=>'HouseholdsController@create','as'=>'society.households.create']);
	    Route::post('{society}/households',['uses'=>'HouseholdsController@store','as'=>'society.households.store']);
	    Route::get('{society}/households/{household}/edit',['uses'=>'HouseholdsController@edit','as'=>'society.households.edit']);
	    Route::put('{society}/households/{household}',['uses'=>'HouseholdsController@update','as'=>'society.households.update']);
	    Route::delete('{society}/households/{household}',['uses'=>'HouseholdsController@destroy','as'=>'society.households.destroy']);*/

});