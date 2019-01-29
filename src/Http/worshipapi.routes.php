<?php
Route::middleware(['handlecors'])->group(function () {
    Route::group(['middleware' => ['jwt.auth','handlecors']], function () {
        Route::post('/api/songs', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SongsController@index','as' => 'worshipapi.songs.index']);
        Route::get('/api/songs/{song}', ['uses' => 'Bishopm\Connexion\Http\Controllers\Api\SongsController@show','as' => 'worshipapi.songs.show']);
    });
});
