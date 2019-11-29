<?php

use Illuminate\Http\Request;

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
//Route::get('/actors', 'ActorController@index');
Route::get('/genres', 'GenresController@index');
Route::get('/bezoekers', 'BezoekerController@index');
Route::get('/genrebestellingen', 'GenrebestellingenController@index');
Route::get('/movies', 'MovieController@index');
Route::delete('/movies/{id}', 'MovieController@destroy');
Route::post('/movies', 'MovieController@store');
Route::get('/genres', 'GenresController@index');
Route::put('/movies/{id}', 'MovieController@edit');

Route::get('/foods', 'FoodController@index');
Route::post('/foods', 'FoodController@store');
Route::put('/foods/{id}', 'FoodController@edit');
Route::delete('/foods/{id}', 'FoodController@destroy');

//userContoller's api for admin
Route::get('/user', 'userController@index');
Route::delete('/user/{id}', 'userController@destroy');
Route::put('/user/{id}', 'userController@edit');


Route::get('/rooms', 'RoomController@index');
Route::delete('/rooms/{id}', 'RoomController@destroy');
Route::post('/rooms', 'RoomController@store');
Route::put('/rooms/{id}', 'RoomController@edit');

Route::get('/actors', 'ActorController@index');
Route::post('/actors', 'ActorController@store');
Route::put('/actors/{id}', 'ActorController@edit');
Route::delete('/actors/{id}', 'ActorController@destroy');

Route::get('/shows', 'ShowController@index');
Route::post('/shows', 'ShowController@store');
Route::put('/shows/{id}', 'ShowController@edit');
Route::delete('/shows/{id}', 'ShowController@destroy');

Route::post('/reviews', 'ReviewController@store');

Route::post('/favorites/{id}', 'FavoriteController@store');
Route::get('/favorites/{id}', 'FavoriteController@getById');
Route::get('/favorites/', 'FavoriteController@index');
Route::delete('/favorites/{id}', 'FavoriteController@destroy');