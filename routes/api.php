<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\RegisterController;
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
Route::post('register',[RegisterController::class,'register']);
Route::post('login',[RegisterController::class,'login']);

//Route::middleware('auth:api')->group(function (){
    Route::get('authors/search',[AuthorController::class,'search']);
    Route::get('books/search',[BookController::class,'search']);
    Route::get('books/genre',[BookController::class,'filter']);
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);
    Route::resource('genres', GenreController::class);
//});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::fallback(function(){
    return response()->json(['message' => 'Not Found!'], 404);
});