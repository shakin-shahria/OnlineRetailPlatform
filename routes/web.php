<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TestMiddleware;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;

// The Welcome route
Route::get('/', fn() => view('welcome'));

// Routes for the admin section
Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->group(function() {
   
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard'); // Changed the name
    Route::resource('/category', 'CategoryController');

    Route::namespace('Auth')->group(function() {

        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login'); // This remains as is
        Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post'); // Added a name for the post route
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    });



    // routes/web.php

   Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
    });
});

});












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
