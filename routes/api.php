<?php
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ItemBrandController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemGenericNameController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;


// Route::middleware(['auth'])->group(function () {
    Route::post('/items/all', [ItemController::class, 'getAllData']);
    Route::post('/items/remove/{item}', [ItemController::class, 'restDisable']);

    Route::post('/item-generic-name/all', [ItemGenericNameController::class, 'getAllData']);
    Route::post('/item-generic-name/remove/{item}', [ItemGenericNameController::class, 'restDisable']);

    Route::post('/item-category/all', [ItemCategoryController::class, 'getAllData']);
    Route::post('/item-category/remove/{item}', [ItemCategoryController::class, 'restDisable']);

    Route::post('/item-brand/all', [ItemBrandController::class, 'getAllData']);
    Route::post('/item-brand/remove/{item}', [ItemBrandController::class, 'restDisable']);

    Route::post('/assets/all', [AssetController::class, 'getAllData']);
    Route::post('/assets/remove/{item}', [AssetController::class, 'restDisable']);

    Route::post('/rentals/all', [RentalController::class, 'getAllData']);
    Route::post('/rentals/remove/{item}', [RentalController::class, 'restDisable']);
    Route::post('/rentals/conflicts', [RentalController::class, 'getConflicts']);
    // });
// });
