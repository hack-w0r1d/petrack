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

Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/posts/create/detail', 'PostController@createDetail')->name('posts.create.detail');
    Route::get('/posts/create/detail', 'PostController@showCreateDetail')->name('posts.create.detail');
    Route::post('/posts/create/confirm', 'PostController@createConfirm')->name('posts.create.confirm');
    Route::get('/posts/create/confirm', 'PostController@showCreateConfirm')->name('posts.create.confirm');
    Route::resource('posts', 'PostController');
    Route::resource('profile', 'ProfileController');
    Route::resource('pets', 'PetController');
});
