<?php

use App\Http\Controllers\TrackingController;
use App\Http\Controllers\TrackingTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('tracking_token', [TrackingTokenController::class, 'store'])->name('tracking_token.store');
Route::post('tracking/notificacion', [TrackingController::class, 'list_notificacion'])->name('tracking.notificacion');
Route::post('tracking/list_mercaderia_nueva_app', [TrackingController::class, 'list_mercaderia_nueva_app'])->name('tracking.list_mercaderia_nueva_app');
Route::post('tracking/{id}/mercaderia_surtida', [TrackingController::class, 'insert_mercaderia_surtida'])->name('tracking.insert_mercaderia_surtida');