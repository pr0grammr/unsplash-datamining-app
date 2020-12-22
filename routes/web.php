<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UnsplashController;
use App\Http\Controllers\UnsplashUserController;
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

Route::middleware(['auth'])->group(function () {

    Route::prefix('unsplash')->group(function () {
        Route::get('/', [UnsplashController::class, 'show'])->name('unsplash-index');

        Route::get('/users/{unsplashUser}',[UnsplashUserController::class, 'show'])->name('unsplash-user-detail');
        Route::get('/users/{unsplashUser}/followers', [UnsplashUserController::class, 'showFollowers'])->name('unsplash-user-detail-followers');

        Route::get('/photos/{unsplashPhoto}',[UnsplashController::class, 'showPhotoDetail'])->name('unsplash-photo-detail');

        Route::post('/analyze',[UnsplashController::class, 'analyzeInput'])->name('unsplash-analyze');
    });

    Route::get('/dashboard',[DashboardController::class, 'show'])->name('dashboard-index');
});

Route::get('/', function() {
    return redirect()->route('unsplash-index');
});
