<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::post('add-product', [ProductsController::class, 'addProduct'])->name('add-product');
Route::get('get-products', [ProductsController::class, 'getProducts'])->name('get-products');
Route::delete('delete-product', [ProductsController::class, 'deleteProduct'])->name('delete-product');
Route::get('/get-product-details', [ProductsController::class, 'getProductDetails'])->name('get-product-details');
Route::post('/update-product', [ProductsController::class, 'getsProductDetails'])->name('update-product');
Route::put('/update-product', [ProductsController::class, 'updateProduct'])->name('update-product');

Route::get('migrate', function () {
    Artisan::call('migrate');
    return response()->json(['message' => "done"]);
});
Route::get('migrate-rollback', function () {
    Artisan::call('migrate:rollback');
    return response()->json(['message' => "done"]);
});
