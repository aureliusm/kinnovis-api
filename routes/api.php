<?php

use App\Http\Controllers\Api\v1\Auth\LoginController;
use App\Http\Controllers\Api\v1\Items\ItemFiltersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// We create a v1 group so we can version our API
Route::prefix('v1')->group(function () {
    // Demo login
    Route::post('/login', LoginController::class)->name('login');

    // We use cache header to cache the requests for a max age of 60 seconds
    Route::middleware('auth:sanctum', 'cache.headers:public;max_age=60;etag')->group(function () {
        Route::get('/items/filters', ItemFiltersController::class)->name('items.filters');
    });
});
