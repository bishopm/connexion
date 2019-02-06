<?php
Route::middleware(['handlecors'])->group(function () {
    Route::group(['middleware' => ['jwt.auth','handlecors']], function () {
        // SETS
        Route::get('/api/sets/{id}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SetsController@find','as' => 'worshipapi.sets.find']);
        Route::get('/api/sets', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SetsController@index','as' => 'worshipapi.sets.index']);
        Route::post('/api/sets', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SetsController@show','as' => 'worshipapi.sets.show']);
        // SETITEMS
        Route::post('/api/setitems/reorder', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SetsController@reorder','as' => 'worshipapi.sets.reorder']);
        Route::post('/api/setitems/remove', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SetsController@removeitem','as' => 'worshipapi.sets.removeitem']);
        Route::post('/api/setitems/add', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SetsController@additem','as' => 'worshipapi.sets.additem']);
        // SONGS
        Route::get('/api/news', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SongsController@news','as' => 'worshipapi.songs.news']);
        Route::get('/api/songs', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SongsController@allsongs','as' => 'worshipapi.songs.allsongs']);
        Route::post('/api/songs', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SongsController@index','as' => 'worshipapi.songs.index']);
        Route::get('/api/songs/{song}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SongsController@show','as' => 'worshipapi.songs.show']);
        Route::post('/api/songs/update', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SongsController@update','as' => 'worshipapi.songs.update']);
        // USERS
        Route::post('/api/users/byphone', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\UsersController@byphone','as' => 'worshipapi.users.byphone']);
    });
});
