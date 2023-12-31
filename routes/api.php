<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StripeController;
use App\Http\Controllers\VesselController;
use App\Http\Controllers\AddOnController;
use App\Http\Controllers\GoogleMapAPIController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BillController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('payments')->group(function () {
    Route::get('/create-connect-stripe', [StripeController::class, 'connectToStripe']);
    Route::get('/check-onboarding', [StripeController::class, 'checkOnboarding']);
    Route::get('/get-stripe-link', [StripeController::class, 'CreateAccountLink']);
    Route::get('/stripe-account-exist', [StripeController::class, 'stripeAccountExist']);
    Route::get('/get-publishable-key', [StripeController::class, 'GetPublishableKey']);
    Route::post('/create-client-for-connected-account', [StripeController::class, 'createClientForConnectedAccount']);
    Route::post('/create-stripe-payment-intent', [StripeController::class, 'stripePaymentIntent']);
    Route::post('/create-checkout-session', [StripeController::class, 'createCheckoutSession']);
    Route::post('/verify-check-out', [StripeController::class, 'verifyCheckoutSession'])->name('subscription.verify');
    Route::post('/create-account-payment-intent', [StripeController::class, 'createAccountPaymentIntent']);
});

Route::prefix('vessels')->group(function () {
    Route::get('/', [VesselController::class, 'getVessels']);
    Route::get('/get-id', [VesselController::class, 'getVesselById']);
});

Route::prefix('addons')->group(function () {
    Route::get('/', [AddOnController::class, 'getAddons']);
});

Route::prefix('googlemap')->group(function () {
    Route::get('/place-id', [GoogleMapAPIController::class, 'GetPlaceId'])->name('map.get.id');
    Route::get('/autocomplete', [GoogleMapAPIController::class, 'autocomplete'])->name('map.get.prediction');
    Route::get('/get-distance-to-home', [GoogleMapAPIController::class, 'getDistance'])->name('map.get.distance');
});

Route::prefix('reservations')->group(function () {
    Route::post('/create', [ReservationController::class, 'CreateReservation']);    
    Route::get('/get-pendings', [ReservationController::class, 'getPendings']);
    Route::post('/collect-final-charges', [ReservationController::class, 'collectFinalCharges']);
});

Route::prefix('bills')->group(function () {
    Route::post('/create-bill-for-reservation', [BillController::class, 'createBillForReservation']);
});