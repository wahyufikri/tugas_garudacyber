<?php

use App\Http\Controllers\AssignmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\SubmissionController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/courses', [CourseController::class,'index']);
    Route::post('/courses', [CourseController::class,'store']);
    Route::put('/courses/{id}', [CourseController::class,'update']);
    Route::delete('/courses/{id}', [CourseController::class,'destroy']);
    Route::post('/courses/{id}/enroll', [CourseController::class,'enroll']);
    Route::post('/courses/{id}/materials', [MaterialController::class, 'store']);
    Route::get('/materials/{id}/download', [MaterialController::class, 'download']);
    Route::post('/courses/{id}/assignments', [AssignmentController::class, 'store']);
    Route::get('/assignments/{id}', [AssignmentController::class, 'show']);
    Route::post('/assignments/{id}/submit', [SubmissionController::class, 'store']);
    Route::post('/submissions/{id}/grade', [SubmissionController::class, 'grade']);
});


