<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('user.index');
});

Route::delete('user/destroy-bulk', [UserController::class, 'destroyBulk'])->name('user.destroy-bulk');

// Standard resource routes for user (index, create, store, edit, update, destroy)
Route::resource('user', UserController::class)->except(['show']);
