<?php

use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\SelfProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('admin')->middleware('auth')->name('news.')->group(function () {
        Route::get('news/create', [NewsController::class, 'add'])->name('add');
        Route::post('news/create', [NewsController::class, 'create'])->name('create');
    });

    Route::prefix('admin')->middleware('auth')->name('profile.')->group(function () {
        Route::get('profile/create', [ProfileController::class, 'add'])->name('add');
        Route::post('profile/create', [ProfileController::class, 'create'])->name('create');
    });

    Route::prefix('admin')->middleware('auth')->name('profile.')->group(function () {
        Route::get('profile/edit', [SelfProfileController::class, 'edit'])->name('edit');
        Route::post('profile/edit', [SelfProfileController::class, 'update'])->name('update');
    });
});

require __DIR__ . '/auth.php';