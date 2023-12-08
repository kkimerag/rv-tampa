<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StripeController;

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
    Route::post('/create-stripe-payment-intent', [StripeController::class, 'stripePaymentIntent']);
    Route::post('/create-checkout-session', [StripeController::class, 'createCheckoutSession']);
    Route::post('/verify-check-out', [StripeController::class, 'verifyCheckoutSession'])->name('subscription.verify');
});