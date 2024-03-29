<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TimelineController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\RepostController;
use App\Http\Controllers\Api\MediaTypesController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/timeline', [TimelineController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::post('/posts/{post}/likes', [LikeController::class, 'store']);
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy']);
Route::post('/posts/{post}/reposts', [RepostController::class, 'store']);
Route::delete('/posts/{post}/reposts', [RepostController::class, 'destroy']);
Route::post('/media', [MediaController::class, 'store']);
Route::get('/media/types', [MediaTypesController::class, 'index']);
Route::post('/posts/{post}/quotes', [QuoteController::class, 'store']);
Route::get('/posts/{post}/replies', [ReplyController::class, 'index']);
Route::post('/posts/{post}/replies', [ReplyController::class, 'store']);
Route::get('/notifications', [NotificationController::class, 'index']);
