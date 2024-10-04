<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('supplier')->middleware(['auth', 'role:supplier'])->group(function () {
    Filament::routes();
});
