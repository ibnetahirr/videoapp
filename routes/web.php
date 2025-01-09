<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EndUsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CommentController;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::post('/post-comment', [CommentController::class, 'store'])->name('post.comment');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');
Route::post('creator/store', [DashboardController::class, 'store'])->name('manual');
Route::post('video/store', [VideoController::class, 'store'])->name('video.store');
