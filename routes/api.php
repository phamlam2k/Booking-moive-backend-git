<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TicketController;


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
    Route::get('/list', [AuthController::class, 'getList']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'movies'
], function ($router) {
    Route::get('/', [MovieController::class, 'index']);
    Route::get('/select', [MovieController::class, 'select']);
    Route::get('/{id}', [MovieController::class, 'detail']);
    Route::post('/store', [MovieController::class, 'store']);
    Route::post('/delete/{id}', [MovieController::class, 'delete']);
    Route::post('/update', [MovieController::class, 'update']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'advertise'
], function ($router) {
    Route::get('/', [AdvertisementController::class, 'index']);
    Route::post('/store', [AdvertisementController::class, 'store']);
    Route::post('/delete/{id}', [AdvertisementController::class, 'delete']);
    Route::post('/update', [AdvertisementController::class, 'update']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'seat'
], function ($router) {
    Route::get('/', [SeatController::class, 'index']);
    Route::get('/{id}', [SeatController::class, 'detail']);
    Route::post('/store', [SeatController::class, 'store']);
    Route::post('/delete/{id}', [SeatController::class, 'delete']);
    Route::post('/update', [SeatController::class, 'update']);
    Route::get('/in_room/{id}', [SeatController::class, 'seatOfRoom']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'room'
], function ($router) {
    Route::get('/', [RoomController::class, 'index']);
    Route::get('/select', [RoomController::class, 'select']);
    Route::get('{id}', [RoomController::class, 'detail']);
    Route::post('/store', [RoomController::class, 'store']);
    Route::post('/delete/{id}', [RoomController::class, 'delete']);
    Route::post('/update', [RoomController::class, 'update']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'showtime'
], function ($router) {
    Route::get('/', [ShowtimeController::class, 'index']);
    Route::get('/gettime', [ShowtimeController::class, 'getTime']);
    Route::get('{id}', [ShowtimeController::class, 'detail']);
    Route::post('/store', [ShowtimeController::class, 'store']);
    Route::post('/delete/{id}', [ShowtimeController::class, 'delete']);
    Route::post('/update', [ShowtimeController::class, 'update']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'news'
], function ($router) {
    Route::get('/', [NewsController::class, 'index']);
    Route::get('/select', [NewsController::class, 'select']);
    Route::get('{id}', [NewsController::class, 'detail']);
    Route::post('/store', [NewsController::class, 'store']);
    Route::post('/delete/{id}', [NewsController::class, 'delete']);
    Route::post('/update', [NewsController::class, 'update']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'tickets'
], function ($router) {
    Route::get('/', [TicketController::class, 'index']);
    Route::post('/order', [TicketController::class, 'orderTicket']);
    Route::post('/pay', [TicketController::class, 'pay']);
    Route::post("/delete", [TicketController::class, 'delete']);
});
