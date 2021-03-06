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
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\VerificationController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/update_profile', [AuthController::class, 'updateProfile']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/re_register', [AuthController::class, 're_register']);

    Route::post('email/verify_OTP',[VerificationController::class,'verify_OTP']);
    Route::post('email/logout_OTP',[VerificationController::class,'logout_OTP']);
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
    Route::post('/store', [ShowtimeController::class, 'store']);
    Route::get('/gettime', [ShowtimeController::class, 'getTime']);
    Route::post('/delete/{id}', [ShowtimeController::class, 'delete']);
    Route::post('/update', [ShowtimeController::class, 'update']);
    Route::get('{id}', [ShowtimeController::class, 'detail']);

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
    Route::get("/ticket_user_id", [TicketController::class, 'ticketByUserID']);
    Route::post("/id", [TicketController::class, 'ticketDetail']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'opinion'
], function ($router) {
    Route::get('/', [OpinionController::class, 'index']);
    Route::get('/select', [OpinionController::class, 'select']);
    Route::post('/store', [OpinionController::class, 'store']);
    Route::post('/delete/{id}', [OpinionController::class, 'delete']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'evaluation'
], function ($router) {
    Route::get('/', [EvaluationController::class, 'index']);
    Route::post('/store', [EvaluationController::class, 'store']);
    Route::post('/delete/{id}', [EvaluationController::class, 'delete']);
});
