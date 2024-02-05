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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(NewsController::class)->prefix('admin')->middleware('auth')->name('news.')->group(function(){
    Route::get('news/create', 'add')->name('add');
    Route::post('news/create', 'create')->name('create');
    Route::get('news', 'index')->name('index');
});

Route::controller(SelfProfileController::class)->prefix('admin')->middleware('auth')->name('profile.')->group(function(){
    Route::get('profile/create', 'add')->name('add');
    Route::post('profile/create', 'create')->name('create');
    Route::get('profile/edit', 'edit')->name('edit');
    Route::post('profile/edit', 'update')->name('update');
    Route::get('profile', 'index')->name('index');
});

require __DIR__.'/auth.php';