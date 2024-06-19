<?php

use App\Http\Controllers\TrackingTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('tracking_token', [TrackingTokenController::class, 'store'])->name('tracking.store');