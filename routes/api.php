<?php

Route::group(['middleware' => 'auth:api'], function() {
    Route::resource('clients', 'ClientController')->except(['edit', 'create']);
});
