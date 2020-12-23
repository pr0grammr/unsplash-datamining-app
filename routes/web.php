<?php

use App\Http\Controllers\Unsplash\AnalyzeController;
use App\Http\Controllers\Unsplash\DashboardController;
use App\Http\Controllers\Unsplash\IndexController;
use App\Http\Controllers\Unsplash\PhotoController;
use App\Http\Controllers\Unsplash\UserController;
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
        Route::get('/', [IndexController::class, 'show'])->name('unsplash-index');

        Route::get('/users/{unsplashUser}',[UserController::class, 'show'])->name('unsplash-user-detail');
        Route::get('/users/{unsplashUser}/followers', [UserController::class, 'showFollowers'])->name('unsplash-user-detail-followers');

        Route::get('/photos/{unsplashPhoto}',[PhotoController::class, 'showPhotoDetail'])->name('unsplash-photo-detail');

        Route::post('/analyze',[AnalyzeController::class, 'analyzeInput'])->name('unsplash-analyze');
    });

    Route::get('/dashboard',[DashboardController::class, 'show'])->name('dashboard-index');
});

Route::get('/', function() {
    return redirect()->route('unsplash-index');
});
