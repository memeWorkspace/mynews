<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SelfProfileController;
use App\Http\Controllers\Admin\NewsController;
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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('admin')->middleware('auth')->group(function () {
        Route::get('news/create', [NewsController::class, 'add'])->name('news.add');
        Route::post('news/create', [NewsController::class, 'create'])->name('news.create');

        Route::get('profile/create', [SelfProfileController::class, 'add'])->name('profile.add');
        Route::post('profile/create', [SelfProfileController::class, 'create'])->name('profile.create');
        Route::get('profile/edit', [SelfProfileController::class, 'edit'])->name('profile.edit');
        Route::post('profile/edit', [SelfProfileController::class, 'update'])->name('profile.update');
    });
});

require __DIR__ . '/auth.php';