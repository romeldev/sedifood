<?php
use Illuminate\Support\Facades\Route;


Route::resource('/common', 'CommonController');

Route::post('login', 'AuthController@login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@user');
});

// setting
Route::namespace('\Modules\Setting\Http\Controllers')->group(function() {
    Route::prefix('setting')->group(function() {
        Route::apiResource('/regimes', 'RegimeController');
        Route::apiResource('/supply-types', 'SupplyTypeController');
        Route::apiResource('/preparation-types', 'PreparationTypeController');
        Route::apiResource('/food-types', 'FoodTypeController');
        Route::apiResource('/coins', 'CoinController');
        Route::apiResource('/professionals', 'ProfessionalController');
        Route::apiResource('/supplies', 'SupplyController');
    });
});

// catering
Route::namespace('\Modules\Catering\Http\Controllers')->group(function() {
    Route::prefix('catering')->group(function() {
        Route::apiResource('/preparations', 'PreparationController');
        Route::apiResource('/programmings', 'ProgrammingController');
        Route::get('/report/supply-order', 'ReportController@reportSupplyOrder');
        Route::get('/report/supply-order/generate', 'ReportController@generateReportSupplyOrder');
    });
});