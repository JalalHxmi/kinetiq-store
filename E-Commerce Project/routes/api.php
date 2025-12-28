<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\StripeWebhookController;

Route::post('/checkout/session', [StripeController::class, 'createSession'])->name('api.checkout.session');
Route::post('/webhook/stripe', [StripeWebhookController::class, 'handle'])->name('api.webhook.stripe');

