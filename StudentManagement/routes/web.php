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

Route::get('/', [\App\Http\Controllers\StudentController::class, 'createAccount']);
//Route::get('/',function(){
//    return view('sign-in');
//});
Route::prefix('/student')->group(function () {
    Route::get('/', [\App\Http\Controllers\StudentController::class, 'index']);
    Route::get('/filter', [\App\Http\Controllers\StudentController::class, 'filterStudent']);
    Route::get('/add', [\App\Http\Controllers\StudentController::class, 'addNewStudent']);
    Route::get('/update', [\App\Http\Controllers\StudentController::class, 'updateStudent']);
    Route::get('/delete', [\App\Http\Controllers\StudentController::class, 'deleteStudent']);
    Route::get('/view-massive-update', [\App\Http\Controllers\StudentController::class, 'indexMassiveUpdate']);
    Route::get('/massive-update-result', [\App\Http\Controllers\ResultController::class, 'massiveUpdate']);
});
Route::prefix('/department')->group(function () {
    Route::get('/', [\App\Http\Controllers\DepartmentController::class, 'index']);
    Route::get('/add-department', [\App\Http\Controllers\DepartmentController::class, 'addNewDepartment']);
    Route::get('/update-department', [\App\Http\Controllers\DepartmentController::class, 'updateDepartment']);
    Route::get('/delete-department', [\App\Http\Controllers\DepartmentController::class, 'deleteDepartment']);
    Route::get('/add-subject', [\App\Http\Controllers\SubjectController::class, 'addNewSubject']);
    Route::get('/update-subject', [\App\Http\Controllers\SubjectController::class, 'updateSubject']);
    Route::get('/delete-subject', [\App\Http\Controllers\SubjectController::class, 'deleteSubject']);
    Route::get('/get-subject', [\App\Http\Controllers\SubjectController::class, 'getSubject']);
});

Route::prefix('/result')->group(function () {
    Route::get('/', [\App\Http\Controllers\ResultController::class, 'index']);
    Route::get('/update', [\App\Http\Controllers\ResultController::class, 'updateResult']);
    Route::get('/delete', [\App\Http\Controllers\ResultController::class, 'deleteResult']);
    Route::get('add', [\App\Http\Controllers\ResultController::class, 'addNewResult']);
});

