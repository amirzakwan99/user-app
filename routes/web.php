<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::resource('user', UserController::class)->except(['show'])
    ->name('index', 'user.index')
    ->name('create', 'user.create')
    ->name('store', 'user.store')
    ->name('edit', 'user.edit')
    ->name('update', 'user.update')
    ->name('destroy', 'user.destroy');
