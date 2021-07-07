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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/students')->group(function () {
    Route::get('/filter', [\App\Http\Controllers\StudentController::class, 'filterStudent'])->name('student.filter');
    Route::get('/view-massive-update', [\App\Http\Controllers\StudentController::class, 'viewMassiveUpdate']);
});

Route::prefix('/departments')->group(function () {
    Route::get('/get-subject', [\App\Http\Controllers\SubjectController::class, 'getSubject']);
});

Route::prefix('/results')->group(function () {
    Route::get('/dismiss-student', [\App\Http\Controllers\StudentController::class, 'sendMailDismiss']);
    Route::get('/massive-update-result', [\App\Http\Controllers\ResultController::class, 'massiveUpdate']);
});

Route::resources(['students' => \App\Http\Controllers\StudentController::class,
    'departments' => \App\Http\Controllers\DepartmentController::class,
    'subjects' => \App\Http\Controllers\SubjectController::class,
    'results' => \App\Http\Controllers\ResultController::class,
    'users' => \App\Http\Controllers\UserController::class
]);
