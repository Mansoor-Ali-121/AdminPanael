<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'index'])->name('admin.home');

Route::prefix('admin')->group(function () {

    // Blogs Route
    Route::get('/blogs/add', [BlogsController::class, 'index'])->name('blog.add');
    Route::post('/blogs/add', [BlogsController::class, 'store']);
    Route::get('/blogs/show', [BlogsController::class, 'show'])->name('blog.show');
    Route::get('/blogs/view/{id}', [BlogsController::class, 'view'])->name('blog.view');
    Route::get('/blogs/edit/{id}', [BlogsController::class, 'edit'])->name('blog.edit');
    Route::patch('/blogs/update/{id}', [BlogsController::class, 'update'])->name('blog.update');
    Route::delete('/blogs/delete/{id}', [BlogsController::class, 'destroy'])->name('blog.delete');

    // Blogs Category Routes
    Route::get('/blogs/category/add', [CategoriesController::class, 'index'])->name('category.add');
    Route::post('/blogs/category/add', [CategoriesController::class, 'store']);
    Route::get('/blogs/category/show', [CategoriesController::class, 'show'])->name('category.show');
    Route::get('/blogs/category/edit/{id}', [CategoriesController::class, 'edit'])->name('category.edit');
    Route::patch('/blogs/category/update/{id}', [CategoriesController::class, 'update'])->name('category.update');
    Route::delete('/blogs/category/delete/{id}', [CategoriesController::class, 'destroy'])->name('category.delete');
    
});
