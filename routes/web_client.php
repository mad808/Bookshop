<?php

use App\Http\Controllers\Client\BookController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\HomeController;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

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

Route::controller(HomeController::class)
    ->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/locale/{locale}', 'locale')->name('locale')->whereIn('locale', ['tm', 'tr', 'en',  'ru',]);
    });

Route::controller(BookController::class)
    ->prefix('books')
    ->name('books.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/userCars', 'userCars')->name('userCars')->middleware('auth');;
        Route::get('/{id}', 'show')->name('show')->where('id', '[0-9]+');
        Route::get('/{id}/favorite', 'favorite')->name('favorite')->where('id', '[0-9]+');
        Route::get('/create', 'create')->name('create')->middleware('auth');
        Route::post('/store', 'store')->name('store')->middleware('auth');
        Route::get('/{id}/edit', 'edit')->name('edit')->where('id', '[0-9A-Za-z-]+')->middleware('auth');
        Route::put('/{id}/update', 'update')->name('update')->where('id', '[0-9A-Za-z-]+')->middleware('auth');
        Route::delete('/{id}/delete', 'delete')->name('delete')->where('id', '[0-9A-Za-z-]+')->middleware('auth');
    });


Route::controller(ContactController::class)
    ->prefix('contacts')
    ->name('contacts.')
    ->group(function () {
        Route::get('', 'index')->name('index')->middleware('auth');
        Route::get('create', 'create')->name('create');
        Route::post('', 'store')->name('store')->middleware(ProtectAgainstSpam::class);
    });
