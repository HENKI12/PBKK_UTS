<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Course_LecturersController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseLecturerController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\Enrollment2Controller;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LecturersController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\UserController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    //Akun
    // Route::controller(UserController::class)->group(function(){
    //     Route::get('/user', 'index');
    //     Route::post('/user/store', 'store');
    //     Route::patch('/user/{id}/update', 'update');
    //     Route::get('/user/{id}','show');
    //     Route::delete('/user/{id}', 'destroy');
    // });

    Route::apiResource('user', UserController::class);
    Route::apiResource('student', StudentController::class);
    Route::apiResource('courselecturers', CourseLecturerController::class);
    Route::apiResource('course', CourseController::class);
    Route::apiResource('lecturers', LecturerController::class);
    Route::apiResource('enrollment', Enrollment2Controller::class);

});





