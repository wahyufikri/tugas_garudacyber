<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/courses', [CourseController::class,'index']);
    Route::post('/courses', [CourseController::class,'store']);
    Route::put('/courses/{id}', [CourseController::class,'update']);
    Route::delete('/courses/{id}', [CourseController::class,'destroy']);
    Route::post('/courses/{id}/enroll', [CourseController::class,'enroll']);
});


