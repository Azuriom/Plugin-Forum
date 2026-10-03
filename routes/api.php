<?php

use Azuriom\Plugin\Forum\Controllers\Api\FeedController;
use Azuriom\Plugin\Forum\Controllers\Api\ForumApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your plugin. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/categories', [ForumApiController::class, 'categories']);
Route::get('/forums/{forum:slug}', [ForumApiController::class, 'forum']);
Route::get('/forums/{forum:slug}/discussions', [ForumApiController::class, 'discussions']);
Route::get('/discussions/latest', [ForumApiController::class, 'latest']);
Route::get('/discussions/{discussion}', [ForumApiController::class, 'discussion']);
Route::get('/discussions/{discussion}/posts', [ForumApiController::class, 'posts']);

Route::get('/rss', [FeedController::class, 'rss']);
Route::get('/atom', [FeedController::class, 'atom']);
Route::get('/forums/{forum:slug}/rss', [FeedController::class, 'forumRss']);
Route::get('/forums/{forum:slug}/atom', [FeedController::class, 'forumAtom']);
