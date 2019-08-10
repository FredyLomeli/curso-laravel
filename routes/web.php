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

Route::get("/usuarios",'UserController@index')->name('users.index');

Route::get('/usuario/{user}', 'UserController@show')
    ->where('user', '[0-9]+')->name('user.show');

Route::get('/usuario/nuevo', 'UserController@create')->name('user.create');

Route::post('/usuario/crear', 'UserController@store')->name('user.store');

Route::get('/usuario/{user}/editar', 'UserController@edit')
    ->where('user', '[0-9]+')->name('user.edit');

Route::put('/usuario/{user}/update', 'UserController@update')
    ->where('user', '[0-9]+')->name('user.update');

Route::delete('/usuario/{user}/delete', 'UserController@destroy')
    ->where('user', '[0-9]+')->name('user.destroy');
    
Route::get('/saludo/{name}/{nickname?}', 'WelcomeUserController@index');
