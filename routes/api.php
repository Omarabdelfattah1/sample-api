<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgetpassword', [AuthController::class, 'forgetpassword']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/tasks', TasksController::class);
    Route::resource('/user-types', UserTypeController::class);
    Route::resource('/posts', PostController::class);
});
