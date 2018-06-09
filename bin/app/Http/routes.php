<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::resource('post', 'PostController');



Route::resource('admin', 'AdminController');

Route::auth();

Route::get('home', 'HomeController@index');
Route::resource('games', 'GamesController');
Route::get('join', 'GamesController@join');
Route::get('delete/games', 'AdminController@deleteGamesView');
Route::get('get/games', 'AdminController@getGames');
Route::get('/delete/game', 'AdminController@deleteGames');
Route::get('delete/users', 'AdminController@deleteUsersView');
Route::get('get/users', 'AdminController@getUsers');
Route::get('/delete/user', 'AdminController@deleteUsers');
Route::get('get_quadrant', 'GamesController@getMapOfQuadrant');
Route::get('command', 'GamesController@eventHandler');
Route::get('help', function (){
    return view('help');
});
Route::get('/statistics', function (){
    return view('statistics');
});
Route::get('top', 'GamesController@top');
Route::get('android', function (){
    return view('android');
});

Route::get('myGames', 'GamesController@myGames');