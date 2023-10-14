<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/lessons', [LessonController::class, 'index']);
Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/types', [TypeController::class, 'index']);

Route::post('/search', [UserController::class, 'search']);

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);

//Pour consulter les infos, modifier ou supprimer un utilisateur, il faut avoir un token valide

Route::middleware('auth:sanctum')->get('/logout', [UserController::class, 'logout']);
Route::middleware('auth:sanctum')->patch('/editUser', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->patch('/editPassword', [UserController::class, 'editPassword']);

Route::middleware('auth:sanctum')->delete('/removeUser', [UserController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/completeActivity/{id}', [UserController::class, 'completeActivity']);

Route::middleware('auth:sanctum')->get('/completeLesson/{id}', [UserController::class, 'completeLesson']);


// Routes qui ne servent pas pour le moment, or outdated

//Route::get('/users', [UserController::class, 'index']);

//Route::middleware('auth:sanctum')->get('/user/{userId}', [UserController::class, 'show']);

// Route::middleware('auth:sanctum')->get('/users/completedActivities', [UserController::class, 'listUserActivities']);

// Route::middleware('auth:sanctum')->get('/users/completedLessons', [UserController::class, 'listUserlessons']);

// Route::get('/lessons/{slug}', [LessonController::class, 'show']);
// Route::get('/activities/{slug}', [ActivityController::class, 'show']);
// Route::get('/types/{id}', [TypeController::class, 'show']);



