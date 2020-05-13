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
    return view('auth.login');
});
//Route::get('/empleados', 'EmpleadosController@index');
//Route::get('/empleados/create', 'EmpleadosController@create');
Route::resource('empleados', 'EmpleadosController')->middleware('auth');
//desactivamos registro y recuperacion de claves..
Auth::routes(['register'=>false, 'reset'=>false]);

Route::get('/home', 'EmpleadosController@index')->name('home');

Route::get('post/create', 'PostController@create');

Route::post('post', 'PostController@store');
