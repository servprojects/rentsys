<?php

use App\Http\Controllers\ItemBrandController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemGenericNameController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('/', [AuthController::class, 'dashboard']); 
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('item-generic-name', ItemGenericNameController::class);
    Route::resource('item-category', ItemCategoryController::class);
    Route::resource('item-brand', ItemBrandController::class);
    Route::resource('items', ItemController::class);
});
