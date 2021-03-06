<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/index', function() {
    return view('index');
});

Route::view('/new',"new");

Route::get('/game', function() {
    return view('game');
});

Route::delete('/todos/{id}/delete', 'TodoController@destroy')->name('todos.destroy');
Route::post('/todos/{id}', 'TodoController@update');
Route::post('/todos', 'TodoController@store');
Route::get('/todos/create', 'TodoController@create');
Route::get('/todos/{id}', 'TodoController@show');
Route::get('/todos/{id}/edit', 'TodoController@edit');
Route::get('/todos', 'TodoController@index')->name('todos');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
