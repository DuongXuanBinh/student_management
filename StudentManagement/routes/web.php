<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::resource('students', \App\Http\Controllers\StudentController::class);
Route::prefix('/students')->group(function () {
    Route::get('/filter', [\App\Http\Controllers\StudentController::class, 'filterStudent']);
    Route::get('/view-massive-update', [\App\Http\Controllers\StudentController::class, 'indexMassiveUpdate']);
    Route::get('/massive-update-result', [\App\Http\Controllers\ResultController::class, 'massiveUpdate']);
});

Route::resource('departments', \App\Http\Controllers\DepartmentController::class);
Route::resource('subjects', \App\Http\Controllers\SubjectController::class);
Route::prefix('/departments')->group(function () {
    Route::get('/get-subject', [\App\Http\Controllers\SubjectController::class, 'getSubject']);
});

Route::resource('results', \App\Http\Controllers\ResultController::class);
Route::prefix('/results')->group(function () {
    Route::get('/dismiss-student', [\App\Http\Controllers\StudentController::class, 'sendMailDismiss']);
});




