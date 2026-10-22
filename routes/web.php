<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', fn () => redirect()->route('products.index'));

Route::resource('products', ProductController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy']);