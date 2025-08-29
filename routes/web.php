<?php

use Azuriom\Plugin\Forum\Controllers\DiscussionController;
use Azuriom\Plugin\Forum\Controllers\DiscussionPollController;
use Azuriom\Plugin\Forum\Controllers\DiscussionPostController;
use Azuriom\Plugin\Forum\Controllers\DiscussionStatusController;
use Azuriom\Plugin\Forum\Controllers\ForumController;
use Azuriom\Plugin\Forum\Controllers\ForumDiscussionController;
use Azuriom\Plugin\Forum\Controllers\PostAttachmentController;
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

Route::resource('discussions', DiscussionController::class)->only(['edit', 'update', 'destroy']);
Route::resource('discussions.posts', DiscussionPostController::class)->only(['store', 'edit', 'update', 'destroy']);

Route::prefix('discussions/{discussion}')->name('discussions.')->group(function () {
    Route::post('/lock', [DiscussionStatusController::class, 'lock'])->name('lock');
    Route::post('/unlock', [DiscussionStatusController::class, 'unlock'])->name('unlock');
    Route::post('/pin', [DiscussionStatusController::class, 'pin'])->name('pin');
    Route::post('/unpin', [DiscussionStatusController::class, 'unpin'])->name('unpin');

    Route::get('/{slug?}', [DiscussionController::class, 'show'])->name('show')->setBindingFields([
        'discussion' => 'routePath',
    ]);
});

Route::resource('posts.attachments', PostAttachmentController::class)->only('store');
Route::post('posts/attachments/{pendingId}', [PostAttachmentController::class, 'pending'])
    ->name('posts.attachments.pending');

Route::prefix('posts/{post}')->name('posts.')->middleware('auth')->group(function () {
    Route::post('/like', [PostLikeController::class, 'addLike'])->name('like');
    Route::delete('/like', [PostLikeController::class, 'removeLike'])->name('dislike');
});

Route::prefix('discussions/{discussion}/poll')->name('discussions.poll.')->group(function () {
    Route::post('/vote', [DiscussionPollController::class, 'vote'])->name('vote');
    Route::delete('/vote', [DiscussionPollController::class, 'removeVote'])->name('vote.remove');
    Route::delete('/', [DiscussionPollController::class, 'destroy'])->name('destroy');
});

Route::resource('users', UserController::class)->only('show')->middleware('throttle:20,1');

Route::prefix('profile')->name('profile.')->middleware('verified')->group(function () {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::post('/', [ProfileController::class, 'update'])->name('update');
});
