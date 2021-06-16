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
Route::prefix('/student')->group(function () {
    Route::get('/', [\App\Http\Controllers\StudentController::class, 'index']);
    Route::get('/filter', [\App\Http\Controllers\StudentController::class, 'filterStudent']);
    Route::get('/add', [\App\Http\Controllers\StudentController::class, 'addNewStudent']);
    Route::get('/update', [\App\Http\Controllers\StudentController::class, 'updateStudent']);
    Route::get('/delete',[\App\Http\Controllers\StudentController::class,'deleteStudent']);
});

Route::get('/department', [\App\Http\Controllers\DepartmentController::class, 'index']);
Route::get('result', [\App\Http\Controllers\ResultController::class, 'index']);
