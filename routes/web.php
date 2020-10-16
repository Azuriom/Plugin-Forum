<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::get('/', 'ForumController@index')->name('home');
Route::get('/{forum:slug}', 'ForumController@show')->name('show');

Route::prefix('{forum:slug}/discussions')->name('forum.discussions.')->group(function () {
    Route::get('/create', 'ForumDiscussionController@create')->name('create');
    Route::post('/', 'ForumDiscussionController@store')->name('store');
});

Route::resource('discussions', 'DiscussionController')->only(['show', 'edit', 'update', 'destroy']);
Route::resource('discussions.posts', 'DiscussionPostController')->only(['store', 'edit', 'update', 'destroy']);

Route::prefix('discussions{discussion}')->name('discussions.')->group(function () {
    Route::post('/lock', 'DiscussionStatusController@lock')->name('lock');
    Route::post('/unlock', 'DiscussionStatusController@unlock')->name('unlock');
    Route::post('/pin', 'DiscussionStatusController@pin')->name('pin');
    Route::post('/unpin', 'DiscussionStatusController@unpin')->name('unpin');
});

Route::prefix('posts/{post}')->name('posts.')->middleware('auth')->group(function () {
    Route::post('/like', 'PostLikeController@addLike')->name('like');
    Route::delete('/like', 'PostLikeController@removeLike')->name('dislike');
});

Route::resource('users', 'UserController')->only('show');

Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/edit', 'ProfileController@edit')->name('edit');
    Route::post('/', 'ProfileController@update')->name('update');
});
