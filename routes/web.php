<?php

use App\Http\Controllers\UnsplashController;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/unsplash', [UnsplashController::class, 'show'])->name('unsplash-index');
Route::get('/unsplash/users/{unsplashUser}', [UnsplashController::class, 'showUserDetail'])->name('unsplash-user-detail');
Route::get('/unsplash/photos/{unsplashPhoto}', [UnsplashController::class, 'showPhotoDetail'])->name('unsplash-photo-detail');
Route::post('/unsplash/analyze', [UnsplashController::class, 'analyzeInput'])->name('unsplash-analyze');
