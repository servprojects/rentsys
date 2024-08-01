<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;


// Route::middleware(['auth'])->group(function () {
    Route::post('/items/all', [ItemController::class, 'getAllData']);
    Route::post('/items/update/{item}', [ItemController::class, 'restDisable']);
// });
