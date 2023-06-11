<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('home');
});

$namespace = 'App\Http\Controllers\\';

Route::resource('/deals', $namespace . 'DealController')->name('index', 'home');
Route::get('/search', $namespace . 'SearchController@index')->name('search');
Route::get('/register', $namespace . 'UserController@create')->name('register.create');
Route::post('/register', $namespace . 'UserController@store')->name('register.store');
Route::get('/login', $namespace . 'UserController@loginForm')->name('login.create');
Route::post('/login', $namespace . 'UserController@login')->name('login');
Route::get('/logout', $namespace . 'UserController@logout')->name('logout');
