<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\AttributesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RolesController;

// The Welcome route
Route::get('/', fn() => view('welcome'));

// Routes for the admin section
Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    
    // Dashboard route
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');

        // Resource routes
        Route::resource('/category', 'CategoryController');
        Route::resource('/attributes', 'AttributesController');
        Route::resource('/products', 'ProductController');
        Route::post('/get-product-details', 'ProductController@getProductDetails')->name('get-product-details');
        
        Route::resource('roles', 'RoleController');
        Route::get('/roles/{roleId}/give-permissions', 'RoleController@addPermissionToRole');
        Route::put('/roles/{roleId}/give-permissions', 'RoleController@givePermissionToRole');
        Route::get('admin/roles/{role}', 'RoleController@show')->name('roles.show');
       // Route::get('/roles/{role}', [RolesController::class, 'show'])->name('roles.show');
       //Route::get('/roles/{role}', 'RolesController@show')->name('roles.show');



        
        Route::resource('users', 'UserController');
        Route::get('admin/users/{user}', 'UserController@show')->name('users.show');
        Route::get('admin/users/{user}', 'UserController@edit')->name('users.edit');
        Route::delete('admin/users/{user}', 'UserController@destroy')->name('users.destroy');
        //Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');





        Route::resource('permissions', 'PermissionController');
        Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');

    });

    // Authentication routes
    Route::namespace('Auth')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post');
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    });
});
