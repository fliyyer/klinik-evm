<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->middleware('auth')->name('home');

require __DIR__.'/auth.php';
