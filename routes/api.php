<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'movies'
], function ($router) {
    Route::get('/', [\App\Http\Controllers\MovieController::class, 'index']);
    Route::get('/{id}', [\App\Http\Controllers\MovieController::class, 'detail']);
    Route::get('/store', [\App\Http\Controllers\MovieController::class, 'store']);
    Route::get('/delete/{id}', [\App\Http\Controllers\MovieController::class, 'delete']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'advertise'
], function ($router) {
    Route::get('/', [\App\Http\Controllers\AdvertisementController::class, 'index']);
});

