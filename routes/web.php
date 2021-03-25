<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', 'TestController@index');

Route::fallback(function() {
    return view('spa');
});