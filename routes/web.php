<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\TestMiddleware;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\AboutUsController;
Auth::routes();
// The Welcome route
Route::get('/', fn() => view('welcome'));

// Routes for the admin section
Route::prefix('admin')->group(function () {

    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Category management routes using resource
    Route::resource('/category', CategoryController::class);
    Route::resource('/attributes', AttributesController::class);
    //Route::resource('/products', ProductController::class);

    // Authentication routes for the admin section

    Route::namespace('Auth')->group(function () {

        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login'); // This remains as is
        Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post'); // Added a name for the post route
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    });
});

Route::namespace("App\Http\Controllers\Admin")->prefix('admin')->group(function(){

   
    Route::resource('/products', 'ProductController');
    Route::post('/get-product-details', 'ProductController@getProductDetails')->name('get-product-details');

   


});



















// use Illuminate\Support\Facades\Route;
// use App\Http\Middleware\TestMiddleware;
// use App\Http\Controllers\ContactUsController;
// use App\Http\Controllers\Admin\Auth\LoginController;
// use App\Http\Controllers\Admin\DashboardController;

// use App\Http\Controllers\Admin\CategoryController;

// // The Welcome route
// Route::get('/', fn() => view('welcome'));

// // Routes for the admin section
// Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->group(function() {
   
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard'); // Changed the name
//     Route::resource('/category', 'CategoryController');

//     Route::namespace('Auth')->group(function() {

//         Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login'); // This remains as is
//         Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post'); // Added a name for the post route
//         Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
//     });
// });












// Other routes

// Route::namespace('App\Http\Controllers')->group(function() {
//     Route::get('/', fn() => view('welcome'));
//     Route::get('/home', [HomeController::class, 'index'])->middleware(TestMiddleware::class);
//     Route::resource('products', ProductController::class);
//     Route::get('/contactus', [ContactUsController::class, 'index'])->name('contact');
//     Route::post('/contactsave', [ContactUsController::class, 'contactsave'])->name('contact-save');
//     Route::get('/contact-entries', [ContactUsController::class, 'showEntries'])->name('contact-entries');
// });

// Auth routes, if needed
// Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Authentication routes for the admin section
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login'); 
    //Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post'); 
    //Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');