<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherAuthController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentController;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prefix('students')->controller(StudentController::class)->group(function () 
// {
//     Route::middleware('auth:admin_api')->group(function () {
//         Route::post('/', 'store');
//         Route::post('update/{id}', 'update');
//         Route::delete('/{id}', 'delete');
//     });

//     Route::middleware('auth:teacher_api')->group(function () {
//         Route::get('/', 'getAllStudent');
//         Route::get('/{id}', 'show');
//     });
// });


Route::prefix('admin')->controller(AuthController::class)->group(function () 
{

    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('adminaddcourse', 'adminaddcourse');
    Route::put('adminupdatecourse', 'adminupdatecourse');
    Route::delete('admindeletecourse', 'admindeletecourse');

    Route::middleware('auth:admin_api')->group(function () 
    {
        Route::post('logout', 'logout');
        Route::post('me', 'me');
    });
});

Route::prefix('teacher')->controller(TeacherAuthController::class)->group(function () 
{

    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('index', 'index');
    Route::put('update/{id}', 'update');
    Route::delete('delete/{id}', 'delete');
    
    Route::middleware('auth:admin_api')->group(function () 
    {
        Route::post('logout', 'logout');
        Route::post('me', 'me');
    });

   
});

Route::prefix('student')->controller(StudentAuthController::class)->group(function () 
{

    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('update/{id}', 'update');
    Route::delete('delete/{id}', 'delete');

    Route::middleware('auth:admin_api')->group(function () 
    {
        Route::post('logout', 'logout');
        Route::post('me', 'me');
    });

   

});