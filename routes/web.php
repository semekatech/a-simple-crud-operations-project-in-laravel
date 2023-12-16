<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
//Auth routes
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login');
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
//product view routes
Route::get('create-product', [ProductsController::class, 'Create'])->name('create-product');
Route::get('manage-products', [ProductsController::class, 'Products'])->name('manage-products');

//users routes
Route::get('create', [UserController::class, 'create_staff'])->name('create-user');
Route::get('staff-users', [UserController::class, 'staff_users'])->name('staff-users');
Route::post('save-user', [UserController::class, 'save_users'])->name('save-user');
Route::get('roles', [RolesController::class, 'index'])->name('roles');
Route::post('save-role', [RolesController::class, 'store'])->name('save-role');
Route::put('/update-role/{id}', [RolesController::class, 'update'])->name('update-role');
Route::delete('delete-role/{id}', [RolesController::class, 'deleteRole'])->name('delete-role');
