<?php
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ItemBrandController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemGenericNameController;
use App\Http\Controllers\LeadSourceController;
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

    Route::post('/lead-source/all', [LeadSourceController::class, 'getAllData']);
    Route::post('/lead-source/remove/{item}', [LeadSourceController::class, 'restDisable']);

    Route::post('/companies/all', [CompanyController::class, 'getAllData']);
    Route::post('/companies/remove/{company}', [CompanyController::class, 'restDisable']);

    Route::post('/clients/all', [ClientController::class, 'getAllData']);
    Route::post('/clients/remove/{client}', [ClientController::class, 'restDisable']);

    Route::post('/rentals/all', [RentalController::class, 'getAllData']);
    Route::post('/rentals/remove/{rental}', [RentalController::class, 'restDisable']);
    Route::post('/rentals/conflicts', [RentalController::class, 'getConflicts']);
    Route::get('/rentals/getmonthlycounts', [RentalController::class, 'getMonthlyCounts']);
    Route::get('/rentals/getcategorycounts', [RentalController::class, 'getCategoryCounts']);
    Route::get('/rentals/getadscounts', [RentalController::class, 'getAdsCounts']);
    Route::post('/rentals/getavailableassets', [RentalController::class, 'getAvailableAssets']);
    // });
// });
