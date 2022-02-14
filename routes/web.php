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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('authors', 'AuthorController');
Route::resource('books', 'BookController');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', 'UserController');
// User is authentication and has admin role
});
