<?php

use App\Helpers\SitemapHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogsController;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DeBlogsController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserRegisterController;

Route::get('/', [Controller::class, 'index'])->name('home');
Route::get('/about-us', [Controller::class, 'about'])->name('about');
Route::get('/sitemap.xml', [Controller::class, 'sitemapXml'])->name('sitemap.xml');

// Route::get('/admin', [AuthController::class, 'index'])->name('home');


// Auth Routes (Without middleware)
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('user.login');
    });
    Route::get('/login', [AuthController::class, 'index'])->name('user.login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Admin Routes (With CheckAdmin middleware)
Route::prefix('admin')->middleware('check.admin')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');
    Route::get('/index', [AdminController::class, 'index'])->name('admin.home');

    // Blogs Routes
    Route::get('/blogs/add', [BlogsController::class, 'index'])->name('blog.add');
    Route::post('/blogs/add', [BlogsController::class, 'store']);
    Route::get('/blogs/show', [BlogsController::class, 'show'])->name('blog.show');
    Route::get('/blogs/view/{id}', [BlogsController::class, 'view'])->name('blog.view');
    Route::get('/blogs/edit/{id}', [BlogsController::class, 'edit'])->name('blog.edit');
    Route::patch('/blogs/update/{id}', [BlogsController::class, 'update'])->name('blog.update');
    Route::delete('/blogs/delete/{id}', [BlogsController::class, 'destroy'])->name('blog.delete');

    // Blog Category Routes
    Route::get('/blogs/category/add', [CategoriesController::class, 'index'])->name('category.add');
    Route::post('/blogs/category/add', [CategoriesController::class, 'store']);
    Route::get('/blogs/category/show', [CategoriesController::class, 'show'])->name('category.show');
    Route::get('/blogs/category/edit/{id}', [CategoriesController::class, 'edit'])->name('category.edit');
    Route::patch('/blogs/category/update/{id}', [CategoriesController::class, 'update'])->name('category.update');
    Route::delete('/blogs/category/delete/{id}', [CategoriesController::class, 'destroy'])->name('category.delete');

    // Sitemap Routes
    Route::get('/add_url', [SitemapController::class, 'index'])->name('sitemap.add');
    Route::post('/add_url', [SitemapController::class, 'store']);
    Route::get('/sitemap', [SitemapController::class, 'show'])->name('sitemap.show');
    Route::post('/sitemap/inspect-url', [SitemapController::class, 'inspectUrl'])->name('sitemap.inspect');
    Route::get('/edit_url/{id}', [SitemapController::class, 'edit'])->name('sitemap.edit');
    Route::patch('/update_url/{id}', [SitemapController::class, 'update'])->name('sitemap.update');
    Route::delete('/delete_url/{id}', [SitemapController::class, 'destroy'])->name('sitemap.delete');
    Route::delete('/delete_alternate/{id}', [SitemapController::class, 'deleteAlternate'])->name('alternate.delete');

    // Api routes 
    // Route::get('/index-sitemap', [ApiController::class, 'indexSitemap']);

    // Robots Routes
    Route::get('/add_robots', [RobotsController::class, 'index'])->name('robots.add');
    Route::post('/add_robots', [RobotsController::class, 'store']);
    Route::get('/robots', [RobotsController::class, 'show'])->name('robots.show');
    Route::get('/edit_robots/{id}', [RobotsController::class, 'edit'])->name('robots.edit');
    Route::patch('/update_robots/{id}', [RobotsController::class, 'update'])->name('robots.update');
    Route::delete('/delete_robots/{id}', [RobotsController::class, 'destroy'])->name('robots.delete');

    // Users Routes
    Route::get('/users_add', [UserRegisterController::class, 'index'])->name('user.add');
    Route::post('/users_add', [UserRegisterController::class, 'store']);
    Route::get('/users_show', [UserRegisterController::class, 'show'])->name('user.show');
    Route::get('/users/edit/{id}', [UserRegisterController::class, 'edit'])->name('user.edit');
    Route::patch('/users/update/{id}', [UserRegisterController::class, 'update'])->name('user.update');
    Route::delete('/users/delete/{id}', [UserRegisterController::class, 'destroy'])->name('user.delete');

    // Services Routes
    Route::get('/services/add', [ServicesController::class, 'index'])->name('service.add');
    Route::post('/services/add', [ServicesController::class, 'store'])->name('service.store');
    Route::get('/services', [ServicesController::class, 'show'])->name('service.show');
    Route::get('/services/edit/{id}', [ServicesController::class, 'edit'])->name('service.edit');
    Route::patch('/services/update/{id}', [ServicesController::class, 'update'])->name('service.update');
    Route::delete('/services/delete/{id}', [ServicesController::class, 'destroy'])->name('service.delete');


    // Booking  route 
    Route::get('/all-bookings', [BookingController::class, 'allbookings'])->name('allbookings');


});
// use App\Helpers\SitemapHelper;

// Site map  helper function
Route::get('/{slug}', function ($slug) {
    return SitemapHelper::getpagecontentforthisurl($slug);
});


// require_once app_path('Helpers/SitemapHelper.php');
