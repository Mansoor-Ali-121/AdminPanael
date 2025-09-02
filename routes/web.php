<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'index'])->name('admin.home');
Route::get('/blogs', [AdminController::class, 'blogs'])->name('admin.blogs');