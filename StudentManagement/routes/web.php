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
Route::get('/',function (){
    return view('layout.sign-in');
});

Route::prefix('/students')->group(function () {
    Route::get('/filter', [\App\Http\Controllers\StudentController::class, 'filterStudent'])->name('student.filter');
    Route::get('/view-massive-update', [\App\Http\Controllers\StudentController::class, 'viewMassiveUpdate']);
    Route::get('/massive-update-result', [\App\Http\Controllers\ResultController::class, 'massiveUpdate']);
    Route::get('/abc/{id}', [\App\Http\Controllers\StudentController::class, 'abc']);
});

Route::prefix('/departments')->group(function () {
    Route::get('/get-subject', [\App\Http\Controllers\SubjectController::class, 'getSubject']);
});

Route::prefix('/results')->group(function () {
    Route::get('/dismiss-student', [\App\Http\Controllers\StudentController::class, 'sendMailDismiss']);
});

Route::resources(['students' => \App\Http\Controllers\StudentController::class,
    'departments' => \App\Http\Controllers\DepartmentController::class,
    'subjects' => \App\Http\Controllers\SubjectController::class,
    'results' => \App\Http\Controllers\ResultController::class,
    'users' => \App\Http\Controllers\UserController::class
]);


