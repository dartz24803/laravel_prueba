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
//MERCADERÍA NUEVA
Route::post('tracking/list_mercaderia_nueva', [TrackingController::class, 'list_mercaderia_nueva_app'])->name('tracking.list_mercaderia_nueva_app');
Route::post('tracking/{id}/mercaderia_nueva', [TrackingController::class, 'insert_mercaderia_nueva_app'])->name('tracking.insert_mercaderia_nueva_app');
Route::post('tracking/list_surtido_mercaderia_nueva', [TrackingController::class, 'list_surtido_mercaderia_nueva'])->name('tracking.list_surtido_mercaderia_nueva');
Route::post('list_mercaderia_nueva_vendedor', [TrackingController::class, 'list_mercaderia_nueva_vendedor_app'])->name('list_mercaderia_nueva_vendedor_app');
//REQUERIMIENTO DE REPOSICIÓN
Route::post('tracking/{id}/requerimiento_reposicion', [TrackingController::class, 'insert_requerimiento_reposicion_app'])->name('tracking.insert_requerimiento_reposicion_app');
Route::post('tracking/requerimiento_reposicion', [TrackingController::class, 'insert_requerimiento_reposicion_estilo_app'])->name('tracking.insert_requerimiento_reposicion_estilo_app');
Route::post('tracking/list_requerimiento_reposicion', [TrackingController::class, 'list_requerimiento_reposicion_app'])->name('tracking.list_requerimiento_reposicion_app');
Route::post('list_requerimiento_reposicion_vendedor', [TrackingController::class, 'list_requerimiento_reposicion_vendedor_app'])->name('list_requerimiento_reposicion_vendedor_app');
Route::put('tracking/{id}/requerimiento_reposicion', [TrackingController::class, 'update_requerimiento_reposicion_app'])->name('tracking.update_requerimiento_reposicion_app');
//ELIMINAR MERCADERÍA NUEVA O RQ DE REPOSICIÓN
Route::delete('mercaderia_surtida/{id}', [TrackingController::class, 'delete_mercaderia_surtida_app'])->name('mercaderia_surtida.destroy');
//NUEVAS RUTAS MERCADERÍA NUEVA
Route::post('list_mercaderia_nueva', [TrackingController::class, 'list_mercaderia_nueva_app_new'])->name('tracking.list_mercaderia_nueva_app_new');
//NUEVAS RUTAS REQUERIMIENTO DE REPOSICIÓN
Route::post('list_requerimiento_reposicion', [TrackingController::class, 'list_requerimiento_reposicion_app_new'])->name('tracking.list_requerimiento_reposicion_app_new');
