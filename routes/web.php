<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', 'TestController@index');

Route::fallback(fn() => view('spa'));