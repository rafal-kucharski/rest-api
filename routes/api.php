<?php

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('profile', 'AuthController@profile');
    Route::get('logout','AuthController@logout');

    Route::resource('clients', 'ClientController')->except(['edit', 'create']);
});
