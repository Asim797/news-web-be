<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//   Authentication Apis
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth:sanctum'])->group( function () {
    //   Article Apis
    Route::prefix('articles')->group(function () {
        Route::get('/', [ArticleController::class, 'index']);
        Route::get('/categories', [ArticleController::class, 'categories']);
        Route::get('/sources', [ArticleController::class, 'sources']);
        Route::get('/authors', [ArticleController::class, 'authors']);
    });

    // User Profile Apis
    Route::get('/profile', [UserController::class, 'index']);
    Route::post('/update-profile', [UserController::class, 'updateProfile']);
    Route::post('/update-preferences', [UserController::class, 'updatePreferences']);
    Route::post('/change-password', [UserController::class, 'changePassword']);
});
