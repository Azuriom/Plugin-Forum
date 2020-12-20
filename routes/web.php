<?php

use Azuriom\Plugin\Forum\Controllers\DiscussionController;
use Azuriom\Plugin\Forum\Controllers\DiscussionPostController;
use Azuriom\Plugin\Forum\Controllers\DiscussionStatusController;
use Azuriom\Plugin\Forum\Controllers\ForumController;
use Azuriom\Plugin\Forum\Controllers\ForumDiscussionController;
use Azuriom\Plugin\Forum\Controllers\PostLikeController;
use Azuriom\Plugin\Forum\Controllers\ProfileController;
use Azuriom\Plugin\Forum\Controllers\UserController;
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

Route::get('/', [ForumController::class, 'index'])->name('home');
Route::get('/{forum:slug}', [ForumController::class, 'show'])->name('show');

Route::prefix('{forum:slug}/discussions')->name('forum.discussions.')->group(function () {
    Route::get('/create', [ForumDiscussionController::class, 'create'])->name('create');
    Route::post('/', [ForumDiscussionController::class, 'store'])->name('store');
});

Route::resource('discussions', DiscussionController::class)->only(['show', 'edit', 'update', 'destroy']);
Route::resource('discussions.posts', DiscussionPostController::class)->only(['store', 'edit', 'update', 'destroy']);

Route::prefix('discussions/{discussion}')->name('discussions.')->group(function () {
    Route::post('/lock', [DiscussionStatusController::class, 'lock'])->name('lock');
    Route::post('/unlock', [DiscussionStatusController::class, 'unlock'])->name('unlock');
    Route::post('/pin', [DiscussionStatusController::class, 'pin'])->name('pin');
    Route::post('/unpin', [DiscussionStatusController::class, 'unpin'])->name('unpin');
});

Route::prefix('posts/{post}')->name('posts.')->middleware('auth')->group(function () {
    Route::post('/like', [PostLikeController::class, 'addLike'])->name('like');
    Route::delete('/like', [PostLikeController::class, 'removeLike'])->name('dislike');
});

Route::resource('users', UserController::class)->only('show');

Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::post('/', [ProfileController::class, 'update'])->name('update');
});
