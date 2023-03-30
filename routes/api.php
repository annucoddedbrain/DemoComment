<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('all',[PostController::class, "getAllPublicPost"]);
Route::post('createPost',[PostController::class, "createPost"]);
Route::post('getPostByUser',[PostController::class, "getMyAllPosts"]);



Route::post('comment',[CommentController::class, "comment"]);

Route::post('delete', [CommentController::class,"delete"]);

// Route::post('/post/{user_id}/comments/create',[CommentController::class,'create'])->middleware('auth:sanctum');



