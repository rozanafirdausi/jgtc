<?php

use Illuminate\Http\Request;

Route::group([], function() {
    // Route::get('/', ['as' => 'frontend.home', 'uses' => 'Frontend\HomeController@getIndex']);
    Route::get('/', ['as' => 'frontend.home', 'uses' => 'Frontend\HomeController@index']);
    Route::get('/lineups/{id}', ['as' => 'frontend.lineup', 'uses' => 'Frontend\PerformerController@show']);
    Route::get('/gallery', ['as' => 'frontend.gallery', 'uses' => 'Frontend\GalleryController@index']);
    Route::get('/merchandises', ['as' => 'frontend.merchandise', 'uses' => 'Frontend\MerchandiseController@index']);
});
