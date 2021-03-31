<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', 'TestController@index');

Route::get('/web/report/{type}', 'ReportController@index');

Route::fallback(function() {
    return view('spa');
});