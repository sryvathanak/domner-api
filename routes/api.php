<?php

use App\Http\Controllers\Address\AddressControlller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\MyFavorite\FavoriteController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Stay\StayController;
use App\Http\Controllers\Stay\StayControllerInfo;
use App\Http\Controllers\Tour\ArrangeTourController;
use App\Http\Controllers\Tour\TourControllerInfo;
use App\Http\Controllers\Transaction\BookingController;
use App\Http\Controllers\Transaction\PaymentController;
use App\Http\Controllers\Transport\BusController;
use App\Http\Controllers\Transport\BusControllerInfo;
use App\Http\Controllers\Transport\FlightController;
use App\Http\Controllers\Transport\FlightControllerInfo;
use App\Http\Controllers\Transport\TrainController;
use App\Http\Controllers\Transport\TrainControllerInfo;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/register', [RegisterController::class, 'register']);

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {


    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('me', [AuthController::class, 'me']);
    Route::post('login', [AuthController::class, 'login']);
});
Route::post('/refresh', [RegisterController::class, 'refresh']);
Route::middleware(['auth'])->group(function () {

    //Route::post('/address', [AddressControlller::class,'create']);
    Route::apiResource('/payment', PaymentController::class);
    Route::apiResource('/train-info', TrainControllerInfo::class)->only(['index', 'show']);
    Route::apiResource('/stay-info', StayControllerInfo::class)->only(['index', 'show']);
    Route::apiResource('/flight-info', FlightControllerInfo::class)->only(['index', 'show']);
    Route::apiResource('/bus-info', BusControllerInfo::class)->only(['index', 'show']);
    Route::apiResource('/tour-info', TourControllerInfo::class)->only(['index', 'show']);
    Route::apiResource('/favorite', FavoriteController::class);
    Route::apiResource('/booking', BookingController::class);
    Route::put('/profile', [RegisterController::class, 'update']);
    Route::get('/list-place', [AddressControlller::class, 'list_stay']);

    Route::get('/popular', [BookingController::class, 'popular']);
});

Route::middleware(['auth:api_clients'])->group(function () {
    Route::post('/stay', [StayController::class, 'create']);

    Route::put('/stay/{id}', [StayController::class, 'update']);
    Route::get('/stay', [StayController::class, 'get']);
    Route::delete('/stay/{id}', [StayController::class, 'delete']);

    Route::post('/flight', [FlightController::class, 'create']);
    Route::get('/flight', [FlightController::class, 'get']);
    Route::put('/flight/{id}', [FlightController::class, 'update']);
    Route::delete('/flight/{id}', [FlightController::class, 'delete']);

    Route::post('/bus', [BusController::class, 'create']);
    Route::get('/bus', [BusController::class, 'get']);
    Route::put('/bus/{id}', [BusController::class, 'update']);
    Route::delete('/bus/{id}', [BusController::class, 'delete']);

    Route::post('/train', [TrainController::class, 'create']);
    Route::get('/train', [TrainController::class, 'get']);
    Route::put('/train/{id}', [TrainController::class, 'update']);
    Route::delete('/train/{id}', [TrainController::class, 'delete']);

    Route::post('/tour', [ArrangeTourController::class, 'create']);
    Route::get('/tour', [ArrangeTourController::class, 'get']);
    Route::put('/tour/{id}', [ArrangeTourController::class, 'update']);
    Route::delete('/tour/{id}', [ArrangeTourController::class, 'delete']);

    Route::get('/booking-client', [BookingController::class, 'get']);
    Route::put('/client/profile', [ClientController::class, 'update']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'client'

], function ($router) {


    Route::post('login', [ClientController::class, 'login']);
    Route::post('logout', [ClientController::class, 'logout']);
});

Route::middleware('custom.auth')->group(function () {
    Route::post('/client', [ClientController::class, 'create']);
    Route::delete('/client/{id}', [ClientController::class, 'delete']);
    Route::post('/address', [AddressControlller::class, 'create']);
    Route::post('/service', [ServiceController::class, 'create']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/service/{id}', [ServiceController::class, 'delete']);
});

Route::get('/address', [AddressControlller::class, 'address']);
Route::get('/list-cookie', [RegisterController::class, 'get_cookie']);
