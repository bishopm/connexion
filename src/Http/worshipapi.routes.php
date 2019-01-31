<?php
Route::middleware(['handlecors'])->group(function () {
    Route::group(['middleware' => ['jwt.auth','handlecors']], function () {
        // SETS
        Route::get('/api/sets/{id}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SetsController@find','as' => 'worshipapi.sets.find']);
        Route::get('/api/sets', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SetsController@index','as' => 'worshipapi.sets.index']);
        Route::post('/api/sets', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SetsController@show','as' => 'worshipapi.sets.show']);
        // SONGS
        Route::post('/api/songs', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SongsController@index','as' => 'worshipapi.songs.index']);
        Route::get('/api/songs/{song}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SongsController@show','as' => 'worshipapi.songs.show']);
    });
});
