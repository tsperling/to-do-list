<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Task related routes below here
 */
Route::get('/get-tasks', [TaskController::class, 'getTasks']);
Route::post('/create-task', [TaskController::class, 'createTask']);
Route::post('/complete-task', [TaskController::class, 'completeTask']);
Route::post('/delete-task', [TaskController::class, 'deleteTask']);
