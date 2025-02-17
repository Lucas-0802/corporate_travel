<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\travel_orders\AdminTravelOrdersController;
use App\Http\Controllers\travel_orders\TravelOrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('travel_order')->middleware(['auth:sanctum'])->group(function () {
    Route::post('create', [TravelOrdersController::class, 'create']);
    Route::get('list', [TravelOrdersController::class, 'list']);
    Route::get('getStatistics', [TravelOrdersController::class, 'getStatistics']);
    Route::put('update/{id}', [TravelOrdersController::class, 'update']);
    Route::delete('delete/{id}', [TravelOrdersController::class, 'delete']);
});

Route::prefix('admin/travel_order')->middleware(['auth:sanctum'])->group(function () {
    Route::get('list', [AdminTravelOrdersController::class, 'list']);
    Route::put('update_status/{id}', [AdminTravelOrdersController::class, 'updateStatus']);
});

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('guest')
    ->name('logout');
