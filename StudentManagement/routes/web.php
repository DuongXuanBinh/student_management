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
Route::prefix('/student')->group(function (){
    Route::get('/',[\App\Http\Controllers\StudentController::class,'index']);
    Route::get('/age-filter',[\App\Http\Controllers\StudentController::class,'findByAgeRange']);
    Route::get('/mark-filter',[\App\Http\Controllers\ResultController::class,'findStudentByMark']);
    Route::get('/complete-filter',[\App\Http\Controllers\StudentController::class,'completedStudent']);
    Route::get('/in-progress-filter',[\App\Http\Controllers\StudentController::class,'incompleteStudents']);
    Route::get('/mobile-operator-filter',[\App\Http\Controllers\StudentController::class,'findByMobileOperator']);
    Route::post('/add',[\App\Http\Controllers\StudentController::class,'addNewStudent']);
});

Route::get('/department',[\App\Http\Controllers\DepartmentController::class,'index']);
Route::get('result',[\App\Http\Controllers\ResultController::class,'index']);
