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

Route::middleware(['auth', 'can:isAdmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

    Route::get('/users', 'Admin\UserController@index')->name('admin.users.index');
    Route::get('/posts', 'Admin\PostController@index')->name('admin.posts.index');
    Route::get('/comments', 'Admin\CommentController@index')->name('admin.comments.index');

    Route::delete('/users/destroy/{id}}', 'Admin\UserController@destroy')->name('admin.users.destroy');

    Route::delete('/posts/delete/{id}}', 'Admin\PostController@delete')->name('admin.posts.delete');
    Route::patch('/posts/restore/{id}}', 'Admin\PostController@restore')->name('admin.posts.restore');
    Route::delete('/posts/forceDelete/{id}}', 'Admin\PostController@forceDelete')->name('admin.posts.forceDelete');

    Route::delete('/comments/delete/{id}}', 'Admin\CommentController@delete')->name('admin.comments.delete');
    Route::patch('/comments/restore/{id}}', 'Admin\CommentController@restore')->name('admin.comments.restore');
    Route::delete('/comments/forceDelete/{id}}', 'Admin\CommentController@forceDelete')->name('admin.comments.forceDelete');
});

Route::middleware('auth')->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::post('/posts/create/detail', 'PostController@createDetail')->name('posts.create.detail');
    Route::get('/posts/create/detail', 'PostController@showCreateDetail')->name('posts.create.detail');
    Route::post('/posts/create/confirm', 'PostController@createConfirm')->name('posts.create.confirm');
    Route::get('/posts/create/confirm', 'PostController@showCreateConfirm')->name('posts.create.confirm');

    Route::post('/posts/{post}/like', 'LikeController@store')->name('posts.like');
    Route::delete('/posts/{post}/unlike', 'LikeController@destroy')->name('posts.unlike');

    Route::get('/search', 'PostController@search')->name('search');

    Route::get('/explore', 'PostController@explore')->name('explore');

    Route::resource('posts', 'PostController');
    Route::resource('profile', 'ProfileController');
    Route::resource('pets', 'PetController');

    Route::post('/follow/{user}', 'FollowController@follow')->name('follow');
    Route::delete('/unfollow/{user}', 'FollowController@unfollow')->name('unfollow');
    Route::get('{user}/followings', 'FollowController@followings')->name('followings');
    Route::get('{user}/followers', 'FollowController@followers')->name('followers');
    Route::delete('follows/{user}', 'FollowController@destroy')->name('follows.destroy');

    Route::post('/posts/{post}/comments', 'CommentController@store')->name('comments.store');
});
