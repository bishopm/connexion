<?php 

Route::get('/admin', function () {
    return view('base::dashboard');
});

Route::get('admin/households','bishopm\base\Http\Controllers\HouseholdsController@index');