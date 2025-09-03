<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'index'])->name('admin.home');

Route::prefix('admin')->group(function () {
    Route::get('/blogs/add', [BlogsController::class, 'index'])->name('blog.add');
    Route::post('/blogs/add', [BlogsController::class, 'store']);
    Route::get('/blogs/show', [BlogsController::class, 'show'])->name('blog.show');
    Route::get('/blogs/view/{id}', [BlogsController::class, 'view'])->name('blog.view');
    Route::post('/blogs/edit/{id}', [BlogsController::class, 'update']);
    Route::get('/blogs/delete/{id}', [BlogsController::class, 'destroy'])->name('blog.delete');
    
});
// Route::get('/blogs/add', [AdminController::class, 'blogs'])->name('admin.blogs');