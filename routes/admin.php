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

Route::middleware('can:forum.forums')->group(function () {
    Route::get('/settings', 'SettingController@show')->name('settings');
    Route::post('/settings', 'SettingController@save')->name('settings.save');

    Route::resource('forums', 'ForumController')->except('show');
    Route::resource('categories', 'CategoryController')->except(['index', 'show']);

    Route::post('/forums/update-order', 'ForumController@updateOrder')->name('forums.update-order');
});
