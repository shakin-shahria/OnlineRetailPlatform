<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

//Route::get('/getCategories', 'ApiController@getCategories')->name('get-categories');
Route::get('/getCategories', [ApiController::class, 'getCategories']);

Route::get('/getProductsByCategoryId/{cid}', [ApiController::class, 'getProductsByCategoryId']);

Route::get('/getProductsById/{pid}', [ApiController::class, 'getProductsById'])->name('get-products-by-id');