<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\HomeController;

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
Route::group(['middleware' => 'locale'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/change-language/{language}', [UserController::class, 'changeLanguage'])->name('change-language');
    Route::get('callback/{provider}', [SocialController::class, 'callback']);
    Route::get('/auth/redirect/{provider}', [SocialController::class, 'redirect'])->name('login.sns');

    require __DIR__ . '/auth.php';
    Auth::routes();
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        Route::group(['middleware' => 'role:admin'], function () {
            Route::prefix('/students')->group(function () {
                Route::get('/{slug}/results', [StudentController::class, 'viewMassiveUpdate'])->name('students.massive-update');
                Route::get('/dismiss-student', [StudentController::class, 'sendMailDismiss'])->name('students.dismiss');
                Route::put('/massive-update', [StudentController::class, 'massiveUpdate'])->name('results.massive-update');
            });

            Route::prefix('/departments')->group(function () {
                Route::get('/get-subject', [SubjectController::class, 'getSubject']);
            });

            Route::resources(['students' => StudentController::class,
                'departments' => DepartmentController::class,
                'subjects' => SubjectController::class,
//                'results' => ResultController::class,
            ]);
        });
        Route::group(['middleware' => 'role:student'], function () {
            Route::prefix('/user')->group(function () {
                Route::get('/result', [UserController::class, 'getResult'])->name('user.result');
                Route::post('/result/enroll', [UserController::class, 'enroll'])->name('user.enroll');
            });
            Route::resource('user', UserController::class)->only(['index', 'update','edit']);
        });
        Route::group(['middleware' => 'role:student|admin'], function () {
            Route::get('/students/filter', [StudentController::class, 'filterStudent'])->name('student.filter');
            Route::resource('students', StudentController::class)->only(['index']);
        });
    });
});
