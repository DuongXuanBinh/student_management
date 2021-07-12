<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('results',\App\Http\Controllers\Api\ResultController::class);

Route::group(['middleware'=>'auth:api'], function(){
//    Route::get('/dismiss-student', [\App\Http\Controllers\StudentController::class, 'sendMailDismiss']);
//    Route::get('/massive-update-result', [\App\Http\Controllers\ResultController::class, 'massiveUpdate']);
});

