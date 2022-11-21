<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhrasesController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);



Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('logout', [AuthController::class, 'logout']);

      //Users
    Route::get('users', [UserController::class,'read']);
    Route::patch('users', [UserController::class,'editpicture']);

    //Phrases
    Route::get('phrases', [PhrasesController::class,'showAll']);
    Route::get('phrases/{id}', [PhrasesController::class,'showThis']);
    Route::get('phrases/mine', [PhrasesController::class,'showMine']);
    Route::get('phrases/mine/{id}', [PhrasesController::class,'showMineId']);
    Route::post('phrases', [PhrasesController::class,'create']);
    Route::patch('phrases/{id}', [PhrasesController::class,'edit']);
    Route::delete('phrases/{id}', [PhrasesController::class,'delete']);

});

