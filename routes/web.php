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
    //return view('frontend.code_request');
    return redirect()->to('https://ahub.tech');
});

Route::get('/aftertwitchlogin', [App\Http\Controllers\HandleLogin::class, 'HandleTwitchLogin'])->name('after_login');

Route::prefix('twitch')->group(function () {
    Route::get('/config', function(){return view('twitch.config');})->name('twitch_config');
    Route::get('/panel', function(){return view('twitch.panel');})->name('twitch_user_panel');
    Route::get('/test', [App\Http\Controllers\Twitch\Viewer::class, 'TestTwitchIntegration'])->name('test-twitch');
});

Route::middleware('admin')->prefix('admin')->group(function(){
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'listUsers'])->name('users');
    Route::get('/user/{id}', [App\Http\Controllers\Admin\UserController::class, 'editUser'])->name('user_edit');
    Route::post('user/{id}', [App\Http\Controllers\Admin\UserController::class, 'updateUser'])->name('user_save');
    Route::get('/user/delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'deleteUser'])->name('user_delete');
    Route::get('/channels', [App\Http\Controllers\Admin\TwitchChannelController::class, 'list'])->name('channels');
    Route::get('/channel/{id}', [App\Http\Controllers\Admin\TwitchChannelController::class, 'editChannel'])->name('twitch_channel_edit');
    Route::post('/channel/{id}', [App\Http\Controllers\Admin\TwitchChannelController::class, 'updateChannel'])->name('twitch_channel_save');
    Route::get('/channel/delete/{id}', [App\Http\Controllers\Admin\TwitchChannelController::class, 'deleteChannel'])->name('twitch_channel_delete');
});

Route::middleware('unity')->prefix('unity')->group(function(){
    Route::get('/avatar/', [App\Http\Controllers\Twitch\StreamerController::class, 'ShowAvatarOnBrowser'])->name('avatar');
});

Auth::routes();
