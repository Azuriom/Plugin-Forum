<?php

use Azuriom\Plugin\Forum\Controllers\Admin\CategoryController;
use Azuriom\Plugin\Forum\Controllers\Admin\ForumController;
use Azuriom\Plugin\Forum\Controllers\Admin\SettingController;
use Azuriom\Plugin\Forum\Controllers\Admin\TagController;
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

Route::middleware('can:forum.forums')->group(function () {
    Route::get('/settings', [SettingController::class, 'show'])->name('settings');
    Route::post('/settings', [SettingController::class, 'save'])->name('settings.save');

    Route::resource('forums', ForumController::class)->except('show');
    Route::resource('categories', CategoryController::class)->except(['index', 'show']);
    Route::resource('tags', TagController::class)->except(['create', 'show']);

    Route::post('/forums/update-order', [ForumController::class, 'updateOrder'])->name('forums.update-order');
});
